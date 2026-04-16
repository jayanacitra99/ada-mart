<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">{{$product->name}}</h3>
                    <button class="btn btn-sm btn-info addUnitButton" data-unit="{{url('admin/product-details/create/'.$product->id)}}"><i class="fas fa-plus"></i> Add Unit</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-striped" id="product_details_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Stock</th>
                            <th>Min Order</th>
                            <th>Unit Type</th>
                            <th>Price</th>
                            <th>Sold</th>
                            <th>Promo</th>
                            <th>Promo Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no=1;
                        @endphp
                        @foreach ($details as $detail)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td>{{$detail->min_order}}</td>
                                <td>{{$detail->unit_type}}</td>
                                <td>Rp.{{$detail->price}}</td>
                                <td>{{$detail->sold}}</td>
                                <td>{{$detail->promo_detail}}</td>
                                <td>Rp.{{$detail->promo_price}}</td>
                                <td class="text-center">
                                    <a actionURL="{{ url('admin/product-details/'.$detail->id) }}" class="btn btn-sm btn-danger buttonDelete" title="Delete Unit"><i class="fas fa-trash"></i></a>
                                    <a data-url="{{ url('admin/product-details/'.$detail->id.'/edit') }}" class="btn btn-sm btn-info editUnitButton" title="Edit Unit"><i class="fas fa-edit"></i></a>
                                </td>
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
    $("#product_details_table").DataTable({
        "responsive": true, 
        "searching" : false,
        "lengthChange": false, 
        "autoWidth": false,
    });
</script>