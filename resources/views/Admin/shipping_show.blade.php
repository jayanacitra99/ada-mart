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
                            <th>Shipping Number</th>
                            <th>Type</th>
                            <th>Destination</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                            <th>Proof Image</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{$shipping->shipping_number}}</td>
                                <td>{{$shipping->type}}</td>
                                <td>{{$shipping->address->full_address ?? '-'}}</td>
                                <td>Rp.{{$shipping->subtotal}}</td>
                                <td>
                                    @if ($shipping->status == 'waiting')
                                        Preparing
                                    @elseif($shipping->status == 'ongoing')
                                        Package Ready
                                    @elseif($shipping->status == 'arrived' or $shipping->status == 'completed')
                                        Completed
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset($shipping->proof_image) }}" target="_blank">
                                        <img src="{{ asset($shipping->proof_image) }}" alt="{{ basename($shipping->proof_image) }}" class="img-size-64">
                                    </a>
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