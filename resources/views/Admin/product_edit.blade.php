@extends('Admin.layout')
@section('title')
    Edit Product
@endsection
@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/products')}}">All Products</a></li>
                  <li class="breadcrumb-item active">Edit Products</li>
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
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Product Detail</h3>
                        <button href="#" class="btn btn-sm btn-info detailProduct" data-show-detail="{{url('admin/products/'.$product->id)}}" title="Detail Product"><i class="fas fa-search"></i> Detail</button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- form start -->
                    <form method="post" action="{{url('admin/products/'.$product->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$product->name}}">
                            </div>
                            <div class="form-group">
                                <label for="desc">Product Description</label>
                                <textarea class="form-control" id="desc" name="desc">{{$product->description}}</textarea>
                            </div>

                            <div class="form-group d-flex flex-wrap">
                                @foreach(json_decode($product->image, true) as $image)
                                    <div class="mb-3">
                                        <img src="{{ asset($image) }}" alt="Image Preview" class="img-size-64">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image }}">
                                            <label class="form-check-label" for="delete_images[]">Delete Image</label>
                                        </div>
                                    </div>
                                @endforeach
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
    <!-- DataTables  & Plugins -->
    <script src="{{asset('')}}adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/jszip/jszip.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
@endsection
@section('end_scripts')
<script>
    $(document).ready(function(){
        $(document).on('click','.detailProduct',function(){
            let modal = $('#myModal');
            let url = $(this).data('show-detail');
            modal.find('.modal-content').empty();
            modal.find('.modal-content').load(url, function(result){
            modal.modal('show');
            });
        });
        $(document).on('click','.addUnitButton',function(){
            let modal = $('#myModal');
            let url = $(this).data('unit');
            modal.find('.modal-content').empty();
            modal.find('.modal-content').load(url, function(result){
            modal.modal('show');
            });
        });

        $(document).on('click','.editUnitButton',function(){
            let modal = $('#myModal');
            let url = $(this).data('url');
            modal.find('.modal-content').empty();
            modal.find('.modal-content').load(url, function(result){
            modal.modal('show');
            });
        });
    });
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