<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Add Product Detail</h3>
                    <button class="btn btn-sm btn-info detailProduct" data-toggle="modal" data-show-detail="{{url('admin/products/'.$product->id)}}"><i class="fas fa-arrow-left"></i> Back to product details</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- form start -->
                <form method="post" action="{{url('admin/product-details')}}" id="add_unit_form">
                    @csrf
                    <div class="table-responsive">
                        <table class="table no-border" id="form_add_unit">
                            <thead>
                                <tr>
                                    <th>Unit Type</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Min Order</th>
                                    <th>Promo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-3">
                                        <input type="text" class="form-control" id="unit_type" name="unit_type" value="{{old('unit_type')}}">
                                    </td>
                                    <td class="col-2">
                                        <input type="number" min="1" class="form-control" id="price" name="price" value="{{old('price')}}">
                                    </td>
                                    <td class="col-2">
                                        <input type="number" min="0" class="form-control" id="quantity" name="quantity" value="{{old('quantity')}}">
                                    </td>
                                    <td class="col-2">
                                        <input type="number" min="1" class="form-control" id="min_order" name="min_order" value="{{old('min_order')}}">
                                    </td>
                                    <td class="col-3">
                                        <select class="custom-select" name="promo_id">
                                            <option value="">-- No Promo --</option>
                                            @foreach ($promos as $promo)
                                                <option value="{{$promo->id}}">{{$promo->name.' ('.$promo->promo_detail.' | '.$promo->valid_date.')'}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> --}}
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
<!-- /.col -->
</div>
<!-- /.row -->
<script>
    function submitForm() {
        let formData = $('#add_unit_form').serializeArray();

        // Add additional data
        formData.push({name: 'product_id', value: {{$product->id}}});
        $.ajax({
            url: "{{url('admin/product-details')}}", // Replace with your endpoint URL
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.notif) {
                    Toast.fire({
                        icon: 'success',
                        title: response.notif.text,
                    });
                    let modal = $('#myModal');
                    let url = "{{url('admin/products/'.$product->id)}}";
                    modal.find('.modal-content').empty();
                    modal.find('.modal-content').load(url, function(result){
                        modal.modal('show');
                    });
                }
            },
            error: function(error) {
                Toast.fire({
                    icon: 'error',
                    title: JSON.parse(error.responseText).message,
                });
            }
        });
    }
</script>