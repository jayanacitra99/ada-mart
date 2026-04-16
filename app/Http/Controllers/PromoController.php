<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'promos'    => Promo::all()
        ];
        return view('Admin.promos', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.promo_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name'      => [
                'required',
                'string',
                Rule::unique('promos','name')
            ],
            'promo_code'=> [
                'required',
                'string',
                'max:8',
                Rule::unique('promos','promo_code')
            ],
            'type'      => 'required|string',
            'amount'    => 'required|numeric|min:1',
            'valid_date'=> 'required|string'
        ];
    
        if($request->type == 'discount'){
            $rules['max_amount']    = 'required|numeric|min:1';
            $rules['amount']        = 'required|numeric|min:1|max:100';
        }
    
        $request->validate($rules);

        $dates = explode(' - ', $request->valid_date);

        $valid_from = Carbon::createFromFormat('m/d/Y H:i', $dates[0])->format('Y-m-d H:i:s');
        $valid_until = Carbon::createFromFormat('m/d/Y H:i', $dates[1])->format('Y-m-d H:i:s');

        // Insert into the database
        $data = [
            'name' => $request->name,
            'promo_code' => $request->promo_code,
            'type' => $request->type,
            'amount' => $request->amount,
            'max_amount' => $request->max_amount ?? null,
            'valid_from' => $valid_from,
            'valid_until' => $valid_until
        ];

        Promo::create($data);

        $options = [
            'type' => 'success',
            'text' => 'Promo Created',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/promos');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'promo' => Promo::find($id),
        ];
        return view('Admin.promo_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name'      => [
                'required',
                'string',
                Rule::unique('promos','name')->ignore($id)
            ],
            'promo_code'=> [
                'required',
                'string',
                'max:8',
                Rule::unique('promos','promo_code')->ignore($id)
            ],
            'type'      => 'required|string',
            'amount'    => 'required|numeric|min:1',
            'valid_date'=> 'required|string'
        ];
    
        if($request->type == 'discount'){
            $rules['max_amount']    = 'required|numeric|min:1';
            $rules['amount']        = 'required|numeric|min:1|max:100';
        }
    
        $request->validate($rules);

        $dates = explode(' - ', $request->valid_date);

        $valid_from = Carbon::createFromFormat('m/d/Y H:i', $dates[0])->format('Y-m-d H:i:s');
        $valid_until = Carbon::createFromFormat('m/d/Y H:i', $dates[1])->format('Y-m-d H:i:s');

        // Insert into the database
        $data = [
            'name' => $request->name,
            'promo_code' => $request->promo_code,
            'type' => $request->type,
            'amount' => $request->amount,
            'max_amount' => $request->max_amount ?? null,
            'valid_from' => $valid_from,
            'valid_until' => $valid_until
        ];

        Promo::where('id',$id)->update($data);

        $options = [
            'type' => 'success',
            'text' => 'Promo Updated',
        ];
        Session::flash('notif',$options);
        return \redirect('admin/promos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Promo::destroy($id);
    }
}
