<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\PromosFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStorePromosRequest;
use App\Models\Promo;
use App\Http\Requests\V1\StorePromoRequest;
use App\Http\Requests\V1\UpdatePromoRequest;
use App\Http\Resources\V1\PromoCollection;
use App\Http\Resources\V1\PromoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new PromosFilter();
        $filterItems = $filter->transform($request);
        $promos = Promo::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $promos = $this->getQueryFilter($filterItems,$promos);

        return new PromoCollection($promos->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StorePromoRequest $request)
    {
        return new PromoResource(Promo::create($request->all()));
    }

    public function bulkStore(BulkStorePromosRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['promoCode','maxAmount','validFrom','validUntil']);
        }); 
        foreach ($bulk as $data){
            Promo::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new PromoResource($promo->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promo $promo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromoRequest $request, Promo $promo)
    {
        $promo->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo)
    {
        return Promo::destroy($promo->id);
    }
}
