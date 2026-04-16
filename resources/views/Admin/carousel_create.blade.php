@extends('Admin.layout')
@section('title')
    Create Carousel
@endsection
@section('styles')
<!-- daterange picker -->
<link rel="stylesheet" href="{{asset('')}}adminlte/plugins/daterangepicker/daterangepicker.css">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add New Carousel</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/carousels')}}">All Carousels</a></li>
                  <li class="breadcrumb-item active">Add New Carousels</li>
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
                  <h3 class="card-title">Add Carousel</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- form start -->
                    <form method="post" action="{{url('admin/carousels/')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="name">Carousel Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                                </div>
                                <div class="form-group col">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                      <option value="active" {{old('status') == 'active' ? 'selected':''}}>Active</option>
                                      <option value="inactive" {{old('status') == 'inactive' ? 'selected':''}}>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Date and time range:</label>
                  
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                      </div>
                                      <input type="text" class="form-control float-right" name="show_date" id="show_date">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="form-group">
                                <img id="imagePreview" src="" alt="Image Preview" style="max-width: 200px;">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Carousel Image</label>
                                <div class="input-group col-4">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept="image/*" name="image" id="image" onchange="previewImage(event)">
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
    
@endsection
@section('end_scripts')
<!-- date-range-picker -->
<script src="{{asset('')}}adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<script>
    $(document).ready(function(){
        $('#show_date').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            locale: {
            format: 'MM/DD/YYYY hh:mm'
            }
        })
    })
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