@extends('Admin.layout')
@section('title')
    Products
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
              <h1>Products</h1>
            </div>
            
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                <li class="breadcrumb-item active">All Products</li>
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
                    <h3 class="card-title">All Products</h3>
                    <a href="{{url('admin/products/create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Product</a>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="products_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>No.</th>
                          <th>Product Name</th>
                          <th>Description</th>
                          <th>Image</th>
                          <th>Created at</th>
                          <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                          $no = 1;
                      @endphp
                      @foreach ($products as $product)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                              @if(json_decode($product->image, true))
                                  @foreach(json_decode($product->image, true) as $image)
                                      <a href="{{ asset($image) }}" target="_blank">
                                          <img src="{{ asset($image) }}" loading="lazy" alt="{{ basename($image) }}" class="img-size-64">
                                      </a>
                                  @endforeach
                              @else
                                  No Image Available
                              @endif
                            </td>
                            <td>{{ Carbon\Carbon::parse($product->created_at)->format('D, d M Y, H:i:s') }}</td>
                            <td class="text-center">
                                <a actionURL="{{ url('admin/products/'.$product->id) }}" class="btn btn-sm btn-danger buttonDelete" title="Delete Product"><i class="fas fa-trash"></i> Delete</a>
                                <a href="{{ url('admin/products/'.$product->id.'/edit') }}" class="btn btn-sm btn-info" title="Edit Product"><i class="fas fa-edit"></i> Edit</a>
                                <button href="#" class="btn btn-sm btn-secondary detailProduct" data-show-detail="{{url('admin/products/'.$product->id)}}" title="Detail Product"><i class="fas fa-search"></i> Detail</button>
                                <button href="#" class="btn btn-sm btn-warning unpackProduct" data-show-detail="{{url('admin/restock-from-warehouse-logs/'.$product->id)}}" title="Unpack Product"><i class="fas fa-box-open"></i> Unpack</button>
                            </td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>Product Name</th>
                          <th>Description</th>
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
          $(document).on('click','.detailProduct',function(){
              let modal = $('#myModal');
              let url = $(this).data('show-detail');
              modal.find('.modal-content').empty();
              modal.find('.modal-content').load(url, function(result){
                modal.modal('show');
              });
          });
          $(document).on('click','.unpackProduct',function(){
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
          
          $("#products_table").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "order": [[ 0, "desc" ]],
            "buttons": [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 3) {
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
                        columns: [0, 1, 2, 3, 4],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 3) {
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
                        columns: [0, 1, 2, 3, 4],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 3) {
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
                        columns: [0, 1, 2, 3, 4],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 3) {
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
                        columns: [0, 1, 2, 3, 4],
                        format: {
                            body: function (data, row, column, node) {
                                // If it's the column for image, replace the image tag with the image source
                                if (column === 3) {
                                    return $(data).attr('href');
                                }
                                return data;
                            }
                        }
                    }
                },
                'colvis'
            ],
          }).buttons().container().appendTo('#products_table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection