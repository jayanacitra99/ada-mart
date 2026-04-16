<table class="table table-striped w-100" id="orders_table">
    <thead>
        <tr>
            <th class="text-center">Product</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            @php
                $firstOrderDetail = $order->orderDetails()->first();
            @endphp
            <tr class="h-100">
                <td class="h-100">
                    <div class="d-flex justify-content-around align">
                        <div class="text-center align-content-center">
                            <img src="{{asset($firstOrderDetail->productDetail->first_image)}}" class="img-size-64" alt="">
                        </div>
                        <div class="">
                            <div>
                                <strong>{{$firstOrderDetail->productDetail->product->name}}</strong>
                            </div>
                            <div>
                                <span class="text-muted">Type : {{$firstOrderDetail->productDetail->unit_type}}</span>
                            </div>
                            <div>
                                <span>x{{$firstOrderDetail->quantity}}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        @if ($type == 'billed')
                            @if ($order->status != App\Models\Order::PAID and !is_null($order->paid_at))
                                <strong>Your payment receipt has been received and will be verified. Please wait.</strong>
                            @endif
                        @endif
                        @if ($type == 'paid')
                            @if ($order->shipping->status == 'waiting')
                                <strong>Package is being prepared</strong>
                            @elseif($order->shipping->status == 'ongoing')
                                <strong class="text-success">Package Ready</strong>
                            @elseif($order->shipping->status == 'arrived' or $shipping->status == 'completed')
                                <strong class="text-success">Completed</strong>
                            @endif
                        @endif
                        @if ($order->payment->payment_receipt)  
                        <div>
                            <a href="{{asset($order->payment->payment_receipt)}}" rel="noopener" target="_blank" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i> Check Payment Receipt</a>
                            @php
                                $admin = App\Models\User::find(1);
                                $wa_admin = 'wa.me/62' . ltrim($admin->phone, '0');
                            @endphp
                            <a href="https://{{$wa_admin}}?text=Halo%20Admin,%20Saya%20sudah%20melakukan%20pembayaran%20untuk%20Order%20ID%20:%20orderID%20.%20Mohon%20dikonfirmasi,%20Terimakasih." class="btn btn-success btn-sm"><i class="fab fa-whatsapp mr-2 "></i>Confirm to Admin</a>
                        </div>
                        @endif
                    </div>
                </td>
                <td class="h-100 ">
                    <div class="h-100 d-flex flex-column justify-content-between">
                        <strong>Rp {{number_format($firstOrderDetail->subtotal,0,',','.')}}</strong>
                        <div class="d-flex flex-column align-items-end align-content-end">
                            <h3 class="font-weight-light" style="color: #c00000">Total Payment : Rp {{number_format($order->total,0,',','.')}}</h3>
                            <a href="{{url('invoice/'.$order->id)}}" class="btn btn-outline-danger btn-block">{{ $buttonText }}</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
