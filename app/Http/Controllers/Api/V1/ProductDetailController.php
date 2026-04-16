<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ProductDetailsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreProductDetailsRequest;
use App\Models\ProductDetail;
use App\Http\Requests\V1\StoreProductDetailRequest;
use App\Http\Requests\V1\UpdateProductDetailRequest;
use App\Http\Resources\V1\ProductDetailCollection;
use App\Http\Resources\V1\ProductDetailResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProductDetailsFilter();
        $filterItems = $filter->transform($request);
        $productDetails = ProductDetail::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $productDetails = $this->getQueryFilter($filterItems,$productDetails);
        
        return new ProductDetailCollection($productDetails->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreProductDetailRequest $request)
    {
        return new ProductDetailResource(ProductDetail::create($request->all()));
    }

    public function bulkStore(BulkStoreProductDetailsRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['productId','unitType']);
        }); 
        foreach ($bulk as $data){
            ProductDetail::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductDetail $productDetail)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new ProductDetailResource($productDetail->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductDetail $productDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductDetailRequest $request, ProductDetail $productDetail)
    {
        $productDetail->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductDetail $productDetail)
    {
        return ProductDetail::destroy($productDetail->id);
    }
}
