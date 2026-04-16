<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\PaymentsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStorePaymentsRequest;
use App\Models\Payment;
use App\Http\Requests\V1\StorePaymentRequest;
use App\Http\Requests\V1\UpdatePaymentRequest;
use App\Http\Resources\V1\PaymentCollection;
use App\Http\Resources\V1\PaymentResource;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new PaymentsFilter();
        $filterItems = $filter->transform($request);
        $payments = Payment::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $payments = $this->getQueryFilter($filterItems,$payments);

        return new PaymentCollection($payments->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StorePaymentRequest $request)
    {
        $data = $request->all();
        $data['status'] = 'waiting';
        return new PaymentResource(Payment::create($data));
    }

    public function bulkStore(BulkStorePaymentsRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['productId','categoryId']);
        }); 
        foreach ($bulk as $data){
            Payment::create($data);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);

        return new PaymentResource($payment->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $data = $request->all();
        if(!is_null($request->paymentReceipt)){
            $image = $request->file('paymentReceipt');
            $imageName = 'Payment-Order-'.$request->order_id.'_'.time().'.'.$image->extension();
            $image->move(public_path('payment_receipts'),$imageName);
            $data['payment_receipt'] = 'payment_receipts/'.$imageName;
            $order = Order::find($payment->order_id);
            $order->paid_at = Carbon::now();
            $order->save();
        }
        $payment->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        return Payment::destroy($payment->id);
    }
}
