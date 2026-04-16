@extends('Admin.layout')
@section('title')
    Assign Product on Categories
@endsection
@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Assign Products on Categories</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/categories')}}">All Categories</a></li>
                  <li class="breadcrumb-item active">Assign Products on Categories</li>
                </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Assign Products on Categories</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- form start -->
                    <form method="post" action="{{url('admin/product-categories/')}}">
                        @csrf
                        <div class="card-body justify-content-between row text-center">
                            <div class="col">
                                <div class="form-group">
                                    <label>Products</label>
                                    <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select a Product" name="products[]" style="width: 100%;">
                                        @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <span class=""><i class="fas fa-exchange-alt"></i></span>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Categories</label>
                                    <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select a Category" name="categories[]" style="width: 100%;">
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    
@endsection
@section('end_scripts')
<!-- Select2 -->
<script src="{{asset('')}}adminlte/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(document).ready(function(){
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    })
</script>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
        // Update the label text with the selected image name
        var fileName = event.target.files[0].name;
        document.getElementById('imageLabel').innerText = fileName;
    }
</script>
@endsection