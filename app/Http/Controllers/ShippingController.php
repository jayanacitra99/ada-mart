<?php

namespace App\Http\Controllers;

use App\Models\CustomerHistory;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDF;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'order'     => Order::find($id),
            'shipping'   => Shipping::where('order_id', $id)->first(),
        ];
        return view('Admin.shipping_show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status'    => [
                'required',
                'string',
                Rule::in(['ongoing','waiting','arrived'])
            ]
        ]);

        $shipping = Shipping::find($id);
        if (!$shipping) {
            return response()->json(['error' => 'Shipping not found'], 404);
        }
        $shipping->status = $request->status;
        $shipping->save();
        
        if($request->status == 'arrived'){
            $order = Order::find($shipping->order_id);
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            $order->status = Order::COMPLETED;
            $order->completed_at = \now();
            $order->save();

            $orderDetails = $order->orderDetails;
            $productHistories = [];
            foreach($orderDetails as $orderDetail){
                $productHistory = [
                    'product_name'  => $orderDetail->productDetail->product->name,
                    'product_images'=> $orderDetail->productDetail->product->image,
                    'subtotal'      => $orderDetail->subtotal
                ];
                $productHistories[] = \json_encode($productHistory);
            }
            $fullAddress = '';
            $fullAddress .= $order->shipping->address?->full_address ?? '-';
            $fullAddress .= ' | ' . $order->shipping->address?->city ?? '-';
            $fullAddress .= ' | ' . $order->shipping->address?->postal_code ?? '-';
            $fullAddress .= ' ( ' . $order->shipping->address?->additional_instructions .' )' ?? '-' ;
            $destination = [
                'recipient_name'            => $order->shipping->address?->recipient_name ?? '-',
                'recipient_phone_number'    => $order->shipping->address?->recipient_phone_number ?? '-',
                'full_address'              => $fullAddress,
            ];
            $setCustomerHistory = [
                'user_id'           => $order->user_id,
                'order_id'          => $order->id,
                'products'          => json_encode($productHistories),
                'destination'       => json_encode($destination),
                'payment_receipt'   => $order->payment->payment_receipt,
                'promo'             => $order->promo->promo_detail ?? '-',
                'total_raw'         => $order->total,
                'total_final'       => $order->total_final,
            ];
            CustomerHistory::create($setCustomerHistory);
            $notif = [
                'notif' => [
                    'text' => 'Shipping Completed',
                ],
            ];
        } else if($request->status == 'ongoing') {
            $notif = [
                'notif' => [
                    'text' => 'Package Ready to Pick Up or Send',
                ],
            ];
        } else {
            $notif = [
                'notif' => [
                    'text' => 'Package is being prepare',
                ],
            ];
        }
        return response()->json($notif);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generateInvoice(string $id)
    {
        $shipping = Shipping::with('address', 'order.orderDetails.productDetail.product')->find($id);

        $data = [
            'shipping'  => $shipping,
            'customer'  => $shipping->address,
            'order'     => $shipping->order,
        ];

        // return view('Admin.shipping_invoice', $data);   
        $pdf = PDF::loadView('Admin.shipping_invoice', $data);
        return $pdf->download('invoice_order_id_'.$shipping->order_id.'.pdf');
    }
}
