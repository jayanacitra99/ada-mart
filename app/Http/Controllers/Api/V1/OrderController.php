<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\OrdersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreOrdersRequest;
use App\Models\Order;
use App\Http\Requests\V1\StoreOrderRequest;
use App\Http\Requests\V1\UpdateOrderRequest;
use App\Http\Resources\V1\OrderCollection;
use App\Http\Resources\V1\OrderResource;
use App\Models\AllNotification;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\ProductDetail;
use App\Models\Promo;
use App\Models\Shipping;
use App\Models\User;
use App\Utils\NewOrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Faker\Factory as Faker; //test
use Illuminate\Support\Facades\Log;
use Session;
use Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new OrdersFilter();
        $filterItems = $filter->transform($request);
        $orders = Order::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $orders = $this->getQueryFilter($filterItems,$orders);

        return new OrderCollection($orders->with($loadValue)->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $total = 0;
        $order = Order::create([
            'user_id'   => $request->userId,
            'status'    => Order::BILLED,
            'total'     => $total,
            'billed_at' => \now(),
        ]);

        $products = $request->products;

        foreach($products as $product){
            $productDetail = ProductDetail::find($product['id']);
            $promo = $productDetail->promo;
            $discount = !is_null($promo) ? $this->checkDiscount($promo,$productDetail->price) : 0;
            $subtotal = $product['quantity'] * ($productDetail->price - $discount);
            $order->orderDetails()->create([
                'product_detail_id' => $product['id'],
                'product_price'     => $productDetail->promo_price ?? $productDetail->price,
                'quantity'          => $product['quantity'],
                'subtotal'          => $subtotal,
            ]);
            $total += $subtotal;
            $productDetail->quantity -= $product['quantity'];
            $productDetail->save();
        }
        $order->shipping()->create([
            'shipping_number'   => $this->generateUniqueShippingNumber(),
            'subtotal'          => 0,
            'status'            => Shipping::WAITING,
        ]);
        $total += $order->shipping->subtotal;
        $order->total = $total;
        if ($request->promoCode) {
            $promo = Promo::byPromoCode($request->promoCode)->byActive()->first();
            if($promo){
                $order->promo_id = $promo->id;
                $discount = $this->checkDiscount($promo,$total);
                $total -= $discount;
            }
        }
        $order->total_final = $total;
        $order->save();
        $notification = [
            'name'      => 'new_order',
            'type'      => 'success',
            'message'   => 'New Order Coming! Order ID :'.$order->id, 
            'related_id'=> $order->id, 
        ];
        Log::info($notification);
        AllNotification::create($notification);

        $order->payment()->create([
            'total'     => $total,
            'status'    => Payment::WAITING,
        ]);
        
        return new OrderResource($order);
    }

    public function bulkStore(BulkStoreOrdersRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['userId','promoId','billedAt','paidAt']);
        }); 
        foreach ($bulk as $data){
            Order::create($data);
        }
    }

    /**
     * Display the specified resource.  
     */
    public function show(Order $order)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);
        
        return new OrderResource($order->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        if($request->status == 'canceled'){
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();
            foreach($orderDetails as $orderDetail){
                $productDetail = ProductDetail::find($orderDetail->product_detail_id);
                $productDetail->quantity += $orderDetail->quantity;
                $productDetail->save();
            }
        }
        $order->update([
            'status'    => $request->status
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        return Order::destroy($order->id);
    }

    public function checkDiscount(Promo $promo, $price)
    {
        $discount = 0;
        if($promo->active){
            if($promo->type == Promo::VOUCHER){
                $discount = $promo->amount;
            } else if($promo->type == Promo::DISCOUNT){
                $discount = ($price / 100) * $promo->amount;
                $discount = $discount > $promo->max_amount ? $promo->max_amount : $discount;
            }
        } 
        return $discount;
    }
    private function generateUniqueShippingNumber()
    {
        do {
            $shippingNumber = Str::upper(Str::random(16));
        } while (Shipping::where('shipping_number', $shippingNumber)->exists());

        return $shippingNumber;
    }

    public function orderInvoice($order_id){
        $order = Order::with(['shipping.address','orderDetails.productDetail.product'])->find($order_id);

        if($order->status == Order::COMPLETED){
            $data = [
                'orderId'           => $order->id,
                'shippingNumber'    => $order->shipping->shipping_number,
                'totalPayment'      => 'Rp '.number_format($order->total_final, 0, ',', '.'),
                'totalRaw'          => 'Rp '.number_format($order->total, 0, ',', '.'),
                'discount'          => $order->promo ? '- Rp '.number_format($this->checkDiscount($order->promo,$order->total), 0, ',', '.'): '- Rp 0',
                'onPromo'           => $order->promo ? true : false,
                'promoCode'         => $order->promo ? $order->promo->promo_code : '-',
                'paidAt'            => Carbon::parse($order->paid_at)->format('d/m/y'),
                'shippingType'      => $order->shipping->type,
                'shippingSubtotal'  => 'Rp '.number_format($order->shipping->subtotal, 0, ',', '.'),
            ];

            $data['address'] =[
                'recipientName'             => $order->shipping->address->recipient_name,
                'recipientPhoneNumber'      => $order->shipping->address->recipient_phone_number, 
                'city'                      => $order->shipping->address->city,
                'postalCode'                => $order->shipping->address->postal_code,
                'fullAddress'               => $order->shipping->address->full_address,
                'additionalInstructions'    => $order->shipping->address->additional_instructions,
                'combinedAddress'           => $order->shipping->address->combined_address,
            ];
            $total = 0;
            foreach($order->orderDetails as $orderDetail){
                $promo = $orderDetail->productDetail->promo;
                $productStatusPromo = $promo ? $promo->active : false;
                $productPricePromo = $orderDetail->productDetail->promo_price ?? $orderDetail->productDetail->price;
                
                $data['orderDetail'][] = [
                    'productName'       => $orderDetail->productDetail->product->name,
                    'productQuantity'   => $orderDetail->quantity,
                    'productType'       => $orderDetail->productDetail->unit_type,
                    'productPrice'      => $orderDetail->productDetail->price,
                    'productStatusPromo'=> $productStatusPromo,
                    'productPricePromo' => 'Rp '.number_format($productPricePromo, 0, ',', '.'),
                ];
                
                $total += $productPricePromo;
            }
            $data['productSubtotal'] = 'Rp '.number_format($total, 0, ',', '.');
            return response()->json([$data]);
        }
        return response()->json(['message' => 'Order is not completed!']);
    }
}
