@extends('Admin.layout')
@section('title')
    Create Product
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
                <h1>Add New Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/products')}}">All Products</a></li>
                  <li class="breadcrumb-item active">Add New Products</li>
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
                  <h3 class="card-title">Add Product</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- form start -->
                    <form method="post" action="{{url('admin/products/')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label for="desc">Product Description</label>
                                <textarea class="form-control" id="desc" name="desc">{{old('desc')}}</textarea>
                            </div>

                            <div class="form-group">
                                <img id="imagePreview" src="" alt="Image Preview" style="max-width: 200px;">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Product Image</label>
                                <div class="input-group col-4">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept="image/*" name="images[]" id="images" onchange="previewImages(event)" multiple>
                                        <label class="custom-file-label" for="image" id="imageLabel">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Categories</label>
                                <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select a Category" name="categories[]" style="width: 100%;">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
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
    function previewImages(event) {
        var files = event.target.files;
        var output = document.getElementById('imagePreview');
        output.innerHTML = ''; // Clear previous previews
        for (var i = 0; i < files.length; i++) {
            (function(file) { // IIFE to capture file in the loop
                var reader = new FileReader();
                reader.onload = function(){
                    var img = document.createElement('img');
                    img.src = reader.result;
                    img.style.maxWidth = '200px';
                    output.appendChild(img);
                };
                reader.readAsDataURL(file);
            })(files[i]); // Pass the current file to the IIFE
            // Update the label text with the selected image names
            var fileNames = '';
            for (var j = 0; j < files.length; j++) {
                fileNames += files[j].name + ', ';
            }
            document.getElementById('imageLabel').innerText = fileNames.slice(0, -2);
        }
    }

</script>
@endsection