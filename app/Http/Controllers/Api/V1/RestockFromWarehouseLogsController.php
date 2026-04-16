<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\RestockFromWarehouseLogsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreRestockFromWarehouseLogsRequest;
use App\Models\RestockFromWarehouseLogs;
use App\Http\Requests\V1\StoreRestockFromWarehouseLogsRequest;
use App\Http\Requests\V1\UpdateRestockFromWarehouseLogsRequest;
use App\Http\Resources\V1\RestockFromWarehousLogsCollection;
use App\Http\Resources\V1\RestockFromWarehousLogsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RestockFromWarehouseLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new RestockFromWarehouseLogsFilter();
        $filterItems = $filter->transform($request);
        $restockFromWarehouseLogs = RestockFromWarehouseLogs::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $restockFromWarehouseLogs = $this->getQueryFilter($filterItems,$restockFromWarehouseLogs);

        return new RestockFromWarehousLogsCollection($restockFromWarehouseLogs->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreRestockFromWarehouseLogsRequest $request)
    {
        return new RestockFromWarehousLogsResource(RestockFromWarehouseLogs::create($request->all()));
    }

    public function bulkStore(BulkStoreRestockFromWarehouseLogsRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['openedProductId','convertedToProductId','openedAmount','receivedAmount']);
        }); 
        foreach ($bulk as $data){
            RestockFromWarehouseLogs::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RestockFromWarehouseLogs $restockFromWarehouseLog)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new RestockFromWarehousLogsResource($restockFromWarehouseLog->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestockFromWarehouseLogs $restockFromWarehouseLogs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestockFromWarehouseLogsRequest $request, RestockFromWarehouseLogs $restockFromWarehouseLog)
    {
        $restockFromWarehouseLog->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestockFromWarehouseLogs $restockFromWarehouseLog)
    {
        return RestockFromWarehouseLogs::destroy($restockFromWarehouseLog->id);
    }
}
