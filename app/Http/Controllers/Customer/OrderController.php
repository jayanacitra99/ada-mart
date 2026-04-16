<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\AllNotification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\ProductDetail;
use App\Models\Promo;
use App\Models\Shipping;
use App\Models\ShoppingCart;
use Crypt;
use DB;
use Illuminate\Http\Request;
use Log;
use Session;
use Str;

class OrderController extends Controller
{
    public function checkOrder(Request $request)
    {
        $encryptedData = $request->query('data', '');
        $decryptedData = Crypt::decrypt($encryptedData);
        $encrypted = json_decode($decryptedData, true);
        
        if($encrypted['type'] == 'carts'){
            $cartIds = $encrypted['carts'];
            $data = [
                'carts'         => ShoppingCart::whereIn('id',$cartIds)->get(),
            ];
        } else if($encrypted['type'] == 'direct'){
            $productDetail = ProductDetail::where('id',$encrypted['product']['productDetailId'])->first();
            $data = [
                'productDetail'     => $productDetail,
                'quantity'          => (int) $encrypted['product']['quantity'],
                'subtotal_product'  => (int) $encrypted['product']['quantity'] * ($productDetail->promo_price ?? $productDetail->price),
            ];
        }

        $address = Address::where('user_id', auth()->id())->orderBy('is_default','desc')->first();
        if(\is_null($address)){
            $options = [
                'type' => 'warning',
                'text' => 'Please set your address',
            ];
            Session::flash('notif',$options);
            return redirect('my-account');
        }
        $data['type'] = $encrypted['type'];
        $data['address'] = Address::where('user_id', auth()->id())->orderBy('is_default','desc')->first();
        
        return view('Customer.create_order', $data);
    }

    public function encryptData(Request $request)
    {
        $data = $request->input('data');
        $encryptedData = Crypt::encrypt($data);

        return response()->json(['encryptedData' => $encryptedData]);
    }

    public function checkPromo(Request $request)
    {
        $promoCode = $request->input('promo_code');
        $promo = Promo::where('promo_code', $promoCode)->first();

        if ($promo?->active) {
            return response()->json([
                'valid' => true,
                'tag' => $promo->promo_detail   
            ]);
        } else {
            return response()->json(['valid' => false]);
        }
    }

    // In your controller method (e.g., CheckoutController)
    public function calculateTotal(Request $request)
    {
        $subtotal = $request->subtotal;
        $promoCode = $request->promo_code;

        $promo = Promo::where('promo_code', $promoCode)->first();
        if ($promo && $promo->active) {
            $discountedSubtotal = $promo->promo_price($subtotal); 
            $totalPayment = $discountedSubtotal > 0 ? ($subtotal - $discountedSubtotal) : 0;

            return response()->json([
                'promo_subtotal' => 'Rp '.number_format($discountedSubtotal, 0, ',', '.'),
                'total_payment' => 'Rp '.number_format($totalPayment, 0, ',', '.'),
                'total_pay'     => $totalPayment,
            ]);
        } else {
            return response()->json([
                'promo_subtotal' => 'Rp 0',
                'total_payment' => 'Rp '.number_format($subtotal, 0, ',', '.'),
                'total_pay'     => $subtotal,
            ]);
        }
    }

    public function addressesList($address_id)
    {
        $data = [
            'addresses' => Address::where('user_id',auth()->user()->id)->get(),
            'address_id'=> $address_id,
        ];
        return view('Customer.change_address', $data);
    }

    public function submitPaymentPage()
    {
        return view('Customer.submit_payment');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'type'          => 'required|string',
            'total_payment' => 'required|numeric',
            'address_id'    => 'required|numeric',
            'shipping_type' => 'required|string'
        ]);
        $type = $request->input('type');
        if($type == 'carts'){
            $request->validate([
                'cart_ids'      => 'required|array',
            ]);
            $cartIds = $request->input('cart_ids');
        } else {
            $request->validate([
                'productDetailId'   => 'required|numeric',
                'quantity'          => 'required|numeric',
            ]);
            $productDetailId = $request->input('productDetailId');
            $quantity = $request->input('quantity');
        }


        $totalPayment = $request->input('total_payment');
        $promoCode = $request->input('promo_code');
        $addressId = $request->input('address_id');
        $shippingType = $request->input('shipping_type');

        try {
            DB::beginTransaction();
            $promo = Promo::byPromoCode($promoCode)->first();
            $order = Order::create([
                'user_id'   => auth()->id(),
                'promo_id'  => $promo->id ?? null,
                'status'    => Order::BILLED,
                'total'     => $totalPayment,
                'billed_at' => \now(),
            ]);

            // Create order items
            if ($type == 'carts') {
                $carts = ShoppingCart::whereIn('id', $cartIds)->get();
                foreach ($carts as $cart) {
                    if ($cart->productDetail->quantity < $cart->quantity) {
                        return response()->json([
                            'message' => 'Failed to place order.',
                            'error' => 'Insufficient stock for product: ' . $cart->productDetail->product->name
                        ], 422);
                    } else if ($cart->productDetail->min_order > $cart->quantity) {
                        return response()->json([
                            'message' => 'Failed to place order.',
                            'error' => $cart->productDetail->product->name. ' Min Order : '.$cart->productDetail->min_order,
                        ], 422);
                    } else {
                        $order->orderDetails()->create([
                            'product_detail_id' => $cart->product_detail_id,
                            'product_price'     => $cart->productDetail->promo_price ?? $cart->productDetail->price,
                            'quantity'          => $cart->quantity,
                            'subtotal'          => $cart->quantity * ($cart->productDetail->promo_price ?? $cart->productDetail->price)
                        ]);
                        // Reduce the stock of the product (if applicable)
                        $cart->productDetail->decrement('quantity', $cart->quantity);
        
                        // Remove the cart item
                        $cart->delete();
                    }
                }
            } else {
                $productDetail = ProductDetail::find($productDetailId);
                if ($productDetail->quantity < $quantity) {
                    return response()->json([
                        'message' => 'Failed to place order.',
                        'error' => 'Insufficient stock for product: ' . $productDetail->product->name
                    ], 422);
                } else if ($productDetail->min_order > $quantity) {
                    return response()->json([
                        'message' => 'Failed to place order.',
                        'error' => $productDetail->product->name. ' Min Order : '.$productDetail->min_order,
                    ], 422);
                } else {
                    $order->orderDetails()->create([
                        'product_detail_id' => $productDetail->id,
                        'product_price'     => $productDetail->promo_price ?? $productDetail->price,
                        'quantity'          => $quantity,
                        'subtotal'          => $quantity * ($productDetail->promo_price ?? $productDetail->price)
                    ]);
                    // Reduce the stock of the product (if applicable)
                    $productDetail->decrement('quantity', $quantity);
                }
            }
 
            $order->shipping()->create([
                'address_id'        => $addressId,
                'shipping_number'   => $this->generateUniqueShippingNumber(),
                'type'              => $shippingType,
                'subtotal'          => 0,
                'status'            => Shipping::WAITING,
            ]);

            $notification = [
                'name'      => 'new_order',
                'type'      => 'success',
                'message'   => 'New Order Coming! Order ID :'.$order->id,
                'related_id'=> $order->id, 
            ];
            Log::info($notification);
            AllNotification::create($notification);
    
            $order->payment()->create([
                'total'     => $totalPayment,
                'status'    => Payment::WAITING,
            ]);

            DB::commit();
            return response()->json(['message' => 'Order placed successfully!', 'order_id' => $order->id], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to place order.', 'error' => $e->getMessage()], 500);
        }
    }
    
    private function generateUniqueShippingNumber()
    {
        do {
            $shippingNumber = Str::upper(Str::random(16));
        } while (Shipping::where('shipping_number', $shippingNumber)->exists());

        return $shippingNumber;
    }

    public function invoice($order_id)
    {
        $data = [
            'order' => Order::with(['payment','orderDetails.productDetail.product','shipping.address','user','promo'])->find($order_id),
        ];

        return view('Customer.invoice', $data);
    }

    public function invoicePrint($order_id)
    {
        $data = [
            'order' => Order::with(['payment','orderDetails.productDetail.product','shipping.address','user','promo'])->find($order_id),
        ];

        return view('Customer.invoice_print', $data);
    }

    public function submitPayment(Request $request, $orderId)
    {
        $request->validate([
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $order = Order::find($orderId);

        if ($request->hasFile('payment_receipt')) {
            $image = $request->file('payment_receipt');
            $imageName = 'PaymentReceipt-Order-'.$order->id.'_'.time() . '.' . $image->extension();
            $image->move(public_path('payment_receipts'),$imageName);
            $order->payment->payment_receipt = 'payment_receipts/'.$imageName;
            $order->payment->save();
            $order->paid_at = \now();
            $order->save();

            return response()->json(['message' => 'Payment receipt uploaded successfully.']);
        }
        return response()->json(['message' => 'Something Happened .', 'error' => 'Failed to send payment receipt'], 500);
    }

}
