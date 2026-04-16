<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductCategories;
use Illuminate\Http\Request;
use Session;

class ProductCategoryController extends Controller
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
        $data = [
            'products'      => Product::all(),
            'categories'    => Categories::all()
        ];
        return view('Admin.assign_products_on_categories', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'products.*' => 'exists:products,id',
            'categories.*' => 'exists:categories,id',
        ]);

        $products = $request->products;
        $categories = $request->categories;
        foreach($products as $product){
            foreach($categories as $category){
                $check = ProductCategories::where('product_id',$product)->where('category_id',$category)->first();
                if(is_null($check)){
                    ProductCategories::create([
                        'product_id'    => $product,
                        'category_id'   => $category,
                    ]);
                }
            }
        }
        $options = [
            'type' => 'success',
            'text' => 'Product Assigned to Selected Categories',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/categories');
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
        return ProductCategories::destroy($id);
    }
}
