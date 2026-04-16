<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CategoriesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreCategoriesRequest;
use App\Models\Categories;
use App\Http\Requests\V1\StoreCategoriesRequest;
use App\Http\Requests\V1\UpdateCategoriesRequest;
use App\Http\Resources\V1\CategoriesCollection;
use App\Http\Resources\V1\CategoriesResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{

    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CategoriesFilter();
        $filterItems = $filter->transform($request);
        $categories = Categories::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $categories = $this->getQueryFilter($filterItems, $categories);

        return new CategoriesCollection($categories->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreCategoriesRequest $request)
    {
        return new CategoriesResource(Categories::create($request->all()));
    }

    public function bulkStore(BulkStoreCategoriesRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['promoId']);
        }); 
        foreach ($bulk as $data){
            Categories::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $category)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new CategoriesResource($category->loadMissing($loadValue));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriesRequest $request, Categories $category)
    {
        $category->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories)
    {
        return Categories::destroy($categories->id);
    }
}
