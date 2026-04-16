<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CustomerHistoriesFilter;
use App\Http\Controllers\Controller;
use App\Models\CustomerHistory;
use App\Http\Requests\V1\StoreCustomerHistoryRequest;
use App\Http\Requests\V1\UpdateCustomerHistoryRequest;
use App\Http\Resources\V1\CustomerHistoryCollection;
use App\Http\Resources\V1\CustomerHistoryResource;
use Illuminate\Http\Request;

class CustomerHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CustomerHistoriesFilter();
        $filterItems = $filter->transform($request);
        $customer_histories = CustomerHistory::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $customer_histories = $this->getQueryFilter($filterItems,$customer_histories);

        return new CustomerHistoryCollection($customer_histories->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreCustomerHistoryRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerHistory $customerHistory)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new CustomerHistoryResource($customerHistory->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerHistory $customerHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerHistoryRequest $request, CustomerHistory $customerHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerHistory $customerHistory)
    {
        //
    }
}
