<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ProductCategoriesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreProductCategoriesRequest;
use App\Models\ProductCategories;
use App\Http\Requests\V1\StoreProductCategoriesRequest;
use App\Http\Requests\V1\UpdateProductCategoriesRequest;
use App\Http\Resources\V1\ProductCategoriesCollection;
use App\Http\Resources\V1\ProductCategoriesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProductCategoriesFilter();
        $filterItems = $filter->transform($request);
        $productCategories = ProductCategories::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $productCategories = $this->getQueryFilter($filterItems,$productCategories);
        
        return new ProductCategoriesCollection($productCategories->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreProductCategoriesRequest $request)
    {
        return new ProductCategoriesResource(ProductCategories::create($request->all()));
    }

    public function bulkStore(BulkStoreProductCategoriesRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['userId','promoId','billedAt','paidAt']);
        }); 
        foreach ($bulk as $data){
            ProductCategories::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategories $productCategory)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new ProductCategoriesResource($productCategory->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategories $productCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoriesRequest $request, ProductCategories $productCategory)
    {
        $productCategory->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategories $productCategory)
    {
        return ProductCategories::destroy($productCategory->id);
    }
}
