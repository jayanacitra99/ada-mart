<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Order ID : {{$order->id}}</h3>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-striped" id="order_details_table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Receipt</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{$payment->status}}</td>
                                <td>Rp.{{$payment->total}}</td>
                                <td>
                                    <a href="{{ asset($payment->payment_receipt) }}" target="_blank">
                                        <img src="{{ asset($payment->payment_receipt) }}" alt="{{ basename($payment->payment_receipt) }}" class="img-size-64">
                                    </a>
                                </td>
                                <td class="text-center" >
                                    @if ($order->status != 'paid')
                                    <a data-url="{{ url('admin/payments/'.$payment->id) }}" class="btn btn-sm btn-success accPaymentButton" onclick="updatePayment('success')" title="Acc Payment"><i class="fas fa-check-square"></i> Accept</a>    
                                    <a data-url="{{ url('admin/payments/'.$payment->id) }}" class="btn btn-sm btn-danger declinePaymentButton" onclick="updatePayment('failed')" title="Decline Payment"><i class="fas fa-window-close"></i> Decline</a>    
                                    @endif
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
<!-- /.col -->
</div>
<!-- /.row -->
<script>
    $("#order_details_table").DataTable({
        "responsive": true, 
        "searching" : false,
        "lengthChange": false, 
        "autoWidth": false,
    });
</script>
<!-- /.row -->
<script>
    function updatePayment(statusPayment) {

        // Add additional data
        $.ajax({
            url: "{{url('admin/payments/'.$payment->id)}}", // Replace with your endpoint URL
            type: 'POST',
            data: {
                _method: 'PATCH',
                status: statusPayment,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.notif) {
                    Toast.fire({
                        icon: 'success',
                        title: response.notif.text,
                    });
                    let modal = $('#myModal');
                    modal.modal('hide');
                    markAsRead(null);
                }
            },
            error: function(error) {
                
                Toast.fire({
                    icon: 'error',
                    title: JSON.parse(error.responseText).message ?? JSON.parse(error.responseText).error,
                });
            }
        });
    }
</script>