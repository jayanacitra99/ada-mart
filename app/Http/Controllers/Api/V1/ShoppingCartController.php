<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ShoppingCartsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreShoppingCartsRequest;
use App\Models\ShoppingCart;
use App\Http\Requests\V1\StoreShoppingCartRequest;
use App\Http\Requests\V1\UpdateShoppingCartRequest;
use App\Http\Resources\V1\ShoppingCartCollection;
use App\Http\Resources\V1\ShoppingCartResource;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ShoppingCartsFilter();
        $filterItems = $filter->transform($request);
        $shoppingCarts = ShoppingCart::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $shoppingCarts = $this->getQueryFilter($filterItems,$shoppingCarts);

        return new ShoppingCartCollection($shoppingCarts->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreShoppingCartRequest $request)
    {
        $cartQuantity = ShoppingCart::where('user_id', $request->userId)
                    ->where('product_detail_id', $request->productDetailId)
                    ->value('quantity');
        $cart = ShoppingCart::updateOrCreate(
            [
                'user_id' => $request->userId,
                'product_detail_id' => $request->productDetailId
            ],
            ['quantity' => $cartQuantity + $request->quantity]
        );
        
        return new ShoppingCartResource($cart);
    }

    public function bulkStore(BulkStoreShoppingCartsRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['userId','productDetailId']);
        }); 
        foreach ($bulk as $data){
            ShoppingCart::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingCart $shoppingCart)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new ShoppingCartResource($shoppingCart->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShoppingCartRequest $request, ShoppingCart $shoppingCart)
    {
        $shoppingCart->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        return ShoppingCart::destroy($shoppingCart->id);
    }
}
