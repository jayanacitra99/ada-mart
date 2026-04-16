<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">{{$category->name}}</h3>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-striped" id="product_categories_table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Product Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no=1;
                        @endphp
                        @foreach ($products as $product)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$product->product->name}}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-danger" onclick="unassignProduct({{$product->id}})" title="Delete Unit"><i class="fas fa-trash"></i> Unassign</a>
                                    
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
    $("#product_categories_table").DataTable({
        "responsive": true, 
        "searching" : false,
        "lengthChange": false, 
        "autoWidth": false,
    });
</script>
<script>
    function unassignProduct(productCategoryId) {

        // Add additional data
        $.ajax({
            url: "{{url('admin/product-categories/')}}"+'/'+productCategoryId, // Replace with your endpoint URL
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            dataType : 'json',
            success: function(response) {
                Toast.fire({
                        icon: 'success',
                        title: 'Product Unassigned',
                    });
                let modal = $('#myModal');
                modal.modal('hide');
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