@extends('Admin.layout')
@section('title')
    Restock From Warehouse Logs
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
              <h1>Restock From Warehouse Logs</h1>
            </div>
            
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                <li class="breadcrumb-item active">All Restock From Warehouse Logs</li>
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
                    <h3 class="card-title">All Restock From Warehouse Logs</h3>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="restock_from_warehouse_logs_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>No.</th>
                          <th>User Name</th>
                          <th>Opened Product</th>
                          <th>Opened Amount</th>
                          <th>Converted Product</th>
                          <th>Received Amount</th>
                          <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                          $no = 1;
                      @endphp
                      @foreach ($restock_from_warehouse_logs as $restock_from_warehouse_log)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $restock_from_warehouse_log->user->name }}</td>
                            <td>{{ $restock_from_warehouse_log->openedProduct?->product?->name.' | '}}<b>{{$restock_from_warehouse_log->openedProduct->unit_type }}</b></td>
                            <td>{{ $restock_from_warehouse_log->opened_amount }}</td>
                            <td>{{ $restock_from_warehouse_log->convertedToProduct?->product?->name.' | '}}<b>{{$restock_from_warehouse_log->convertedToProduct->unit_type }}</b></td>
                            <td>{{ $restock_from_warehouse_log->received_amount }}</td>
                            <td>{{ Carbon\Carbon::parse($restock_from_warehouse_log->created_at)->format('D, d M Y, H:i:s') }}</td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>User Name</th>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>Unit Type</th>
                          <th>Before Restock</th>
                          <th>Created at</th>
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
          $("#restock_from_warehouse_logs_table").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "buttons": [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    }
                },
                'colvis'
            ],
          }).buttons().container().appendTo('#restock_from_warehouse_logs_table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection