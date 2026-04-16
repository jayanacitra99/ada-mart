<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Promo;
use App\Models\RestockLog;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class ProductDetailController extends Controller
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
    public function create($productID)
    {
        $data = [
            'product'   => Product::find($productID),
            'promos'    => Promo::byActive()->get(),
        ];
        return view('Admin.product_detail_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_type' => [
                'required',
                'string',
                Rule::unique('product_details')->where(function ($query) use ($request) {
                    return $query->where('product_id', $request->product_id);
                })
            ],
            'price'     => 'required|numeric',
            'quantity'  => 'required|numeric',
            'min_order' => 'required|numeric|min:1',
        ]);

        $data = [
            'product_id'    => $request->product_id,
            'unit_type'     => $request->unit_type,
            'price'         => $request->price,
            'quantity'      => $request->quantity,
            'min_order'     => $request->min_order,
            'promo_id'      => $request->promo_id,
        ];

        $product = ProductDetail::create($data);
        RestockLog::create([
            'user_id'       => Auth::user()->id,
            'product_id'    => $product->id,
            'quantity'      => $product->quantity,
            'unit_type'     => $product->unit_type,
            'before_restock'=> 0,
            'after_restock' => $product->quantity,
        ]);
        return response()->json([
            'notif' => [
                'text' => 'Product Unit Created',
            ],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $detail = ProductDetail::find($id);
        $product = Product::find($detail->product_id);
        $data = [
            'product'   => $product,
            'detail'    => $detail,
            'promos'    => Promo::byActive()->get(),
        ];
        return view('Admin.product_detail_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $productDetail = ProductDetail::find($id);
        $qty = $productDetail->quantity;
        $request->validate([
            'unit_type' => [
                'sometimes',
                'required',
                'string',
                Rule::unique('product_details')->where(function ($query) use ($productDetail) {
                    return $query->where('product_id', $productDetail->product_id);
                })->ignore($id)
            ],
            'price'     => 'sometimes|required|numeric',
            'quantity'  => 'sometimes|required|numeric',
            'min_order' => 'sometimes|required|numeric|min:1',
        ]);

        $productDetail->unit_type   = $request->unit_type;
        $productDetail->price       = $request->price;
        $productDetail->quantity    = $request->quantity;
        $productDetail->min_order   = $request->min_order;
        $productDetail->promo_id    = $request->promo_id;
        $productDetail->save();

        RestockLog::create([
            'user_id'       => Auth::user()->id,
            'product_id'    => $productDetail->id,
            'quantity'      => $productDetail->quantity - $qty,
            'unit_type'     => $productDetail->unit_type,
            'before_restock'=> $qty,
            'after_restock' => $productDetail->quantity,
        ]);
        return response()->json([
            'notif' => [
                'text' => 'Product Unit Created',
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ProductDetail::destroy($id);
    }
}
