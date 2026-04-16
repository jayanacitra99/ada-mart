<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\OrderDetailsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreOrderDetailsRequest;
use App\Models\OrderDetail;
use App\Http\Requests\V1\StoreOrderDetailRequest;
use App\Http\Requests\V1\UpdateOrderDetailRequest;
use App\Http\Resources\V1\OrderDetailCollection;
use App\Http\Resources\V1\OrderDetailResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new OrderDetailsFilter();
        $filterItems = $filter->transform($request);
        $orderDetails = OrderDetail::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $orderDetails = $this->getQueryFilter($filterItems,$orderDetails);

        return new OrderDetailCollection($orderDetails->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreOrderDetailRequest $request)
    {
        return new OrderDetailResource(OrderDetail::create($request->all()));
    }

    public function bulkStore(BulkStoreOrderDetailsRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['orderId','productDetailId']);
        }); 
        foreach ($bulk as $data){
            OrderDetail::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderDetail $orderDetail)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new OrderDetailResource($orderDetail->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderDetailRequest $request, OrderDetail $orderDetail)
    {
        $orderDetail->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderDetail $orderDetail)
    {
        return OrderDetail::destroy($orderDetail->id);
    }
}
