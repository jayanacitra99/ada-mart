<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\AddressesFilter;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Http\Requests\V1\StoreAddressRequest;
use App\Http\Requests\V1\UpdateAddressRequest;
use App\Http\Resources\V1\AddressCollection;
use App\Http\Resources\V1\AddressResource;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new AddressesFilter();
        $filterItems = $filter->transform($request);
        $addresses = Address::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $addresses = $this->getQueryFilter($filterItems,$addresses);

        return new AddressCollection($addresses->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreAddressRequest $request)
    {
        // return new AddressResource(Address::create($request->all()));
        // Check if the request has is_default set to true
        if ($request->is_default) {
            // Find any existing default address for the user
            $existingDefaultAddress = Address::where('user_id', $request->user_id)
                ->where('is_default', true)
                ->first();

            // If an existing default address is found, set it to false
            if ($existingDefaultAddress) {
                $existingDefaultAddress->update(['is_default' => false]);
            }
        }

        // Create a new address based on the request
        $newAddress = Address::create($request->all());

        // Return the newly created address as a resource
        return new AddressResource($newAddress);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new AddressResource($address->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        return Address::destroy($address->id);
    }
}
