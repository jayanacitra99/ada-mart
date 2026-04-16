<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\ShippingsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreShippingsRequest;
use App\Models\Shipping;
use App\Http\Requests\V1\StoreShippingRequest;
use App\Http\Requests\V1\UpdateShippingRequest;
use App\Http\Resources\V1\ShippingCollection;
use App\Http\Resources\V1\ShippingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ShippingsFilter();
        $filterItems = $filter->transform($request);
        $shippings = Shipping::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $shippings = $this->getQueryFilter($filterItems,$shippings);

        return new ShippingCollection($shippings->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreShippingRequest $request)
    {
        $data = $request->all();
        $data['status'] = Shipping::WAITING;
        return new ShippingResource(Shipping::create($data));
    }

    public function bulkStore(BulkStoreShippingsRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['orderId','shippingNumber']);
        }); 
        foreach ($bulk as $data){
            Shipping::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipping $shipping)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new ShippingResource($shipping->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShippingRequest $request, Shipping $shipping)
    {
        $shipping->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipping $shipping)
    {
        return Shipping::destroy($shipping->id);
    }
}
