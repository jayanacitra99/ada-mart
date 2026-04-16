<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'orders'    => Order::where('status','paid')->get(),
        ];
        return view('Warehouse.orders', $data);
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
        return view('Warehouse.shipping_show', $data);
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
        if($request->hasFile('proof_image')){
            $image = $request->file('proof_image');

            // Generate a unique name for the image
            $imageName = 'Proof-'.$shipping->id.'_'.time() . '.' . $image->extension();
            // Store the image
            $image->move(public_path('proof_images'),$imageName);
            $shipping->proof_image = 'proof_images/'.$imageName;
        }
        $shipping->status = $request->status;
        $shipping->save();
        
        if($request->status == 'arrived'){
            $order = Order::find($shipping->order_id);
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            $order->status = Order::COMPLETED;
            $order->save();
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
                    'text' => 'Package still being prepare',
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

    public function showOrderDetail(string $id){
        $order = Order::find($id);
        $data = [
            'order'     => $order,
            'details'   => $order->orderDetails,
        ];
        return view('Admin.order_show', $data);
    }

    public function orderHistories()
    {
        $data = [
            'orders'    => Order::where('status','completed')->get(),
        ];
        return view('Warehouse.order_histories', $data);
    }
}
