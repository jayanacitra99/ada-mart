<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\RestockLogsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreRestockLogsRequest;
use App\Models\RestockLog;
use App\Http\Requests\V1\StoreRestockLogRequest;
use App\Http\Requests\V1\UpdateRestockLogRequest;
use App\Http\Resources\V1\RestockLogCollection;
use App\Http\Resources\V1\RestockLogResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RestockLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new RestockLogsFilter();
        $filterItems = $filter->transform($request);
        $restockLogs = RestockLog::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $restockLogs = $this->getQueryFilter($filterItems,$restockLogs);

        return new RestockLogCollection($restockLogs->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreRestockLogRequest $request)
    {
        return new RestockLogResource(RestockLog::create($request->all()));
    }

    public function bulkStore(BulkStoreRestockLogsRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['productId','unitType','beforeRestock','afterRestock']);
        }); 
        foreach ($bulk as $data){
            RestockLog::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RestockLog $restockLog)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new RestockLogResource($restockLog->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestockLog $restockLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestockLogRequest $request, RestockLog $restockLog)
    {
        $restockLog->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestockLog $restockLog)
    {
        return RestockLog::destroy($restockLog->id);
    }
}
