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
                            <th>No.</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no=1;
                        @endphp
                        @foreach ($details as $detail)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$detail->productDetail->product?->name.' ('.$detail->productDetail->unit_type.')'}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td>Rp.{{$detail->subtotal}}</td>
                            </tr>
                        @endforeach
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