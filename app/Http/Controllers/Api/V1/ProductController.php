<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ProductsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreProductsRequest;
use App\Models\Product;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProductsFilter();
        $filterItems = $filter->transform($request);
        $productsQuery = Product::query();
        $queries = $request->query();

        // Apply the filters to the query
        $productsQuery = $this->getQueryFilter($filterItems, $productsQuery);

        // Load the necessary relationships
        $loadValue = $this->getLoadValue($queries);
        $products = $productsQuery->with($loadValue)->get();

        // Sort the products by hasActivePromo in descending order
        $sortedProducts = $products->sortByDesc(function ($product) {
            return $product->hasActivePromo();
        });

        // Paginate the sorted products
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15; // Number of items per page
        $currentItems = $sortedProducts->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedProducts = new LengthAwarePaginator($currentItems, $sortedProducts->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return new ProductCollection($paginatedProducts);
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
    public function store(StoreProductRequest $request)
    {
        return new ProductResource(Product::create($request->all()));
    }

    public function bulkStore(BulkStoreProductsRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, []);
        }); 
        foreach ($bulk as $data){
            Product::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new ProductResource($product->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return Product::destroy($product->id);
    }
}
