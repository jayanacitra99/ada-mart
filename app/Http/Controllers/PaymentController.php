<?php

namespace App\Http\Controllers;

use App\Models\AllNotification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductDetail;
use App\Utils\LowStockNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Log;
use Session;

class PaymentController extends Controller
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
            'payment'   => Payment::where('order_id', $id)->first(),
        ];
        return view('Admin.payment_show', $data);
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
                Rule::in(['success','failed'])
            ]
        ]);

        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }
        $payment->status = $request->status;
        $payment->save();
        
        if($request->status == 'success'){
            $order = Order::find($payment->order_id);
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            $order->status = Order::PAID;
            $order->save();
            $orderDetails = $order->orderDetails;
            foreach($orderDetails as $orderDetail){
                $productDetail = ProductDetail::find($orderDetail->product_detail_id);
                if ($productDetail->quantity < 10) {
                    $notification = [
                        'name'      => 'low_stock',
                        'type'      => 'success',
                        'message'   => 'Product ' . $productDetail->product->name .'('.$productDetail->unit_type.') is almost out of stock.', 
                        'related_id'=> $productDetail->product_id, 
                    ];
                    Log::info($notification);
                    AllNotification::create($notification);
                }
            }
            $notif = [
                'notif' => [
                    'text' => 'Payment Accepted',
                ],
            ];
        } else {
            $notif = [
                'notif' => [
                    'text' => 'Payment Declined',
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
}
