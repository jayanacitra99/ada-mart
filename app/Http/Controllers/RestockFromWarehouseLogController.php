<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\RestockFromWarehouseLogs;
use App\Models\RestockLog;
use Auth;
use Illuminate\Http\Request;
use Session;

class RestockFromWarehouseLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'restock_from_warehouse_logs'   => RestockFromWarehouseLogs::all()->sortByDesc('id')
        ];
        return view('Admin.restock_from_warehouse_logs', $data);
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
        $request->validate([
            'opened_product'    => 'required|numeric|exists:product_details,id',
            'opened'            => 'required|numeric|min:1',
            'converted_product' => 'required|numeric|exists:product_details,id',
            'received'         => 'required|numeric|min:1',
        ]);

        $data = [
            'user_id'                   => Auth::user()->id,
            'opened_product_id'         => $request->opened_product,
            'converted_to_product_id'   => $request->converted_product,
            'opened_amount'             => $request->opened,
            'received_amount'           => $request->received,
        ];

        RestockFromWarehouseLogs::create($data);
        $openedProduct = ProductDetail::find($request->opened_product);
        $qtyOpened = $openedProduct->quantity;
        $openedProduct->quantity -= $request->opened;
        $openedProduct->save();
        
        $convertedProduct = ProductDetail::find($request->converted_product);
        $qtyConverted= $convertedProduct->quantity;
        $convertedProduct->quantity += $request->received;
        $convertedProduct->save();

        RestockLog::create([
            'user_id'       => Auth::user()->id,
            'product_id'    => $openedProduct->product_id,
            'quantity'      => $request->opened * -1,
            'unit_type'     => $openedProduct->unit_type,
            'before_restock'=> $qtyOpened,
            'after_restock' => $openedProduct->quantity,
        ]);

        RestockLog::create([
            'user_id'       => Auth::user()->id,
            'product_id'    => $convertedProduct->product_id,
            'quantity'      => $request->received,
            'unit_type'     => $convertedProduct->unit_type,
            'before_restock'=> $qtyConverted,
            'after_restock' => $convertedProduct->quantity,
        ]);

        $options = [
            'type' => 'success',
            'text' => 'Product Unpacked',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        $data = [
            'product'   => $product,
            'unit_types'=> $product->productDetails
        ];
        return view('Admin.restock_from_warehouse_log_create', $data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
