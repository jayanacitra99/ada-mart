@extends('Admin.layout')
@section('title')
    Categories
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
              <h1>Categories</h1>
            </div>
            
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                <li class="breadcrumb-item active">All Category</li>
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
                    <h3 class="card-title">All Category</h3>
                    <div>
                      <a href="{{url('admin/product-categories/create')}}" class="btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Assign Product on Categories</a>
                      <a href="{{url('admin/categories/create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Category</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="categories_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>No.</th>
                          <th>Category Name</th>
                          <th>Image</th>
                          <th>Created at</th>
                          <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                          $no = 1;
                      @endphp
                      @foreach ($categories as $category)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="{{ asset($category->image) }}" target="_blank">
                                    <img src="{{ asset($category->image) }}" loading="lazy" alt="{{ basename($category->image) }}" class="img-size-64">
                                </a>
                            </td>
                            <td>{{ Carbon\Carbon::parse($category->created_at)->format('D, d M Y, H:i:s') }}</td>
                            <td class="text-center">
                                <a actionURL="{{ url('admin/categories/'.$category->id) }}" class="btn btn-sm btn-danger buttonDelete" title="Delete Category"><i class="fas fa-trash"></i> Delete</a>
                                <a href="{{ url('admin/categories/'.$category->id.'/edit') }}" class="btn btn-sm btn-info" title="Edit Category"><i class="fas fa-edit"></i> Edit</a>
                                <button href="#" class="btn btn-sm btn-secondary detailCategory" data-show-detail="{{url('admin/categories/'.$category->id)}}" title="Detail Category"><i class="fas fa-search"></i> Detail</button>
                            </td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>Category Name</th>
                          <th>Image</th>
                          <th>Created at</th>
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
        $(document).ready(function () {
          $(document).on('click','.detailCategory',function(){
              let modal = $('#myModal');
              let url = $(this).data('show-detail');
              modal.find('.modal-content').empty();
              modal.find('.modal-content').load(url, function(result){
                modal.modal('show');
              });
          });
          
          $("#categories_table").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "buttons": [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 2) {
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
                        columns: [0, 1, 2, 3],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 2) {
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
                        columns: [0, 1, 2, 3],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 2) {
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
                        columns: [0, 1, 2, 3],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 2) {
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
                        columns: [0, 1, 2, 3],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 2) {
                                    return $(data).attr('href');
                                }
                                return data;
                            }
                        }
                    }
                },
                'colvis'
            ],
          }).buttons().container().appendTo('#categories_table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection