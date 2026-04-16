@extends('Admin.layout')
@section('title')
    Edit Category
@endsection
@section('styles')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/categories')}}">All Categories</a></li>
                  <li class="breadcrumb-item active">Edit Category</li>
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
                  <h3 class="card-title">Edit Category</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- form start -->
                    <form method="post" action="{{url('admin/categories/'.$category->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <img id="imagePreview" src="{{asset($category->image)}}" alt="Image Preview" style="max-width: 200px;">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Category Image</label>
                                    <div class="input-group col-4">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="image/*" name="image" id="image" onchange="previewImage(event)">
                                            <label class="custom-file-label" for="image" id="imageLabel">Choose file</label>
                                        </div>
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
    
@endsection
@section('end_scripts')
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