@extends('Admin.layout')
@section('title')
    Carousels
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
              <h1>Carousels</h1>
            </div>
            
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                <li class="breadcrumb-item active">All Carousels</li>
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
                    <h3 class="card-title">All Carousels</h3>
                    <a href="{{url('admin/carousels/create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Carousel</a>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="carousels_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>No.</th>
                          <th>Carousel Name</th>
                          <th>Status</th>
                          <th>Show Date</th>
                          <th>Image</th>
                          <th>Created At</th>
                          <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                          $no = 1;
                      @endphp
                      @foreach ($carousels as $carousel)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $carousel->name }}</td>
                            <td>{{ $carousel->status }}</td>
                            <td>{{ $carousel->show_date }}</td>
                            <td>
                              <a href="{{ asset($carousel->image) }}" target="_blank">
                                  <img src="{{ asset($carousel->image) }}" loading="lazy" alt="{{ basename($carousel->image) }}" class="img-size-64">
                              </a>
                            </td>
                            <td>{{ Carbon\Carbon::parse($carousel->created_at)->format('D, d M Y, H:i:s') }}</td>
                            <td class="text-center">
                                <a actionURL="{{ url('admin/carousels/'.$carousel->id) }}" class="btn btn-sm btn-danger buttonDelete" title="Delete Carousel"><i class="fas fa-trash"></i> Delete</a>
                                <a href="{{ url('admin/carousels/'.$carousel->id.'/edit') }}" class="btn btn-sm btn-info" title="Edit Carousel"><i class="fas fa-edit"></i> Edit</a>
                                @if (!$carousel->is_popup)
                                  <a onclick="setAsPopUp({{ $carousel->id }})" class="btn btn-sm btn-secondary" title="Set Pop Up Carousel"><i class="fas fa-thumbtack"></i> Set as Pop-Up</a>
                                @endif
                            </td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>Carousel Name</th>
                          <th>Status</th>
                          <th>Show Date</th>
                          <th>Image</th>
                          <th>Created At</th>
                          <th></th>
                        </tr>
                    </tfoot>
                  </table>
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

    <script>
      function setAsPopUp(carouselID) {
        Swal.fire({
          title: 'Set this Carousel as Pop Up?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Set it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{url('admin/carousels/set-popup')}}",
                    type: 'POST',
                    data: { carousel_id: carouselID, _token: '{{ csrf_token() }}' },
                    success: function(response) {
                      window.location.reload();
                      Toast.fire({
                          icon: 'success',
                          title: response.notif.text,
                      });
                    },
                    error : function(error){
                      Toast.fire({
                          icon: 'warning',
                          title: JSON.parse(error.responseText).message ?? JSON.parse(error.responseText).error,
                      });
                    }
                });
            }
        });
      } 
        $(document).ready(function () {

          $("#carousels_table").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "buttons": [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 4) {
                                    return $(data).attr('href');
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 4) {
                                    return $(data).attr('href');
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 4) {
                                    return $(data).attr('href');
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 4) {
                                    return $(data).attr('href');
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 4) {
                                    return $(data).attr('href');
                                }
                                return data;
                            }
                        }
                    }
                },
                'colvis'
            ],
          }).buttons().container().appendTo('#carousels_table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection