<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\CarouselsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreCarouselsRequest;
use App\Models\Carousel;
use App\Http\Requests\V1\StoreCarouselRequest;
use App\Http\Requests\V1\UpdateCarouselRequest;
use App\Http\Resources\V1\CarouselCollection;
use App\Http\Resources\V1\CarouselResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CarouselsFilter();
        $filterItems = $filter->transform($request);
        $carousels = Carousel::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $carousels = $this->getQueryFilter($filterItems,$carousels);

        return new CarouselCollection($carousels->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreCarouselRequest $request)
    {
        return new CarouselResource(Carousel::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Carousel $carousel)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new CarouselResource($carousel->loadMissing($loadValue));
    }

    public function bulkStore(BulkStoreCarouselsRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['showFrom','showUntil']);
        }); 
        foreach ($bulk as $data){
            Carousel::create($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carousel $carousel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarouselRequest $request, Carousel $carousel)
    {
        $carousel->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carousel $carousel)
    {
        return Carousel::destroy($carousel->id);
    }
}
