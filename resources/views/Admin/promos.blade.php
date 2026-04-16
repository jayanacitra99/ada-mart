@extends('Admin.layout')
@section('title')
    Promos
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
              <h1>Promos</h1>
            </div>
            
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                <li class="breadcrumb-item active">All Promos</li>
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
                    <h3 class="card-title">All Promos</h3>
                    <a href="{{url('admin/promos/create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Promo</a>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="promos_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>No.</th>
                          <th>Promo Name</th>
                          <th>Promo Code</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Max Amount</th>
                          <th>Valid Date</th>
                          <th>Created at</th>
                          <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                          $no = 1;
                      @endphp
                      @foreach ($promos as $promo)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $promo->name }}</td>
                            <td>{{ $promo->promo_code }}</td>
                            <td>{{ $promo->type }}</td>
                            <td>{{ $promo->type == 'discount' ? $promo->amount.'%' : 'Rp.'.$promo->amount }}</td>
                            <td>{{ $promo->type == 'voucher' ? '-' : 'Rp.'.$promo->max_amount }}</td>
                            <td>{{ $promo->valid_date }}</td>
                            <td>{{ Carbon\Carbon::parse($promo->created_at)->format('D, d M Y, H:i:s') }}</td>
                            <td class="text-center">
                                <a actionURL="{{ url('admin/promos/'.$promo->id) }}" class="btn btn-sm btn-danger buttonDelete" title="Delete Promo"><i class="fas fa-trash"></i> Delete</a>
                                <a href="{{ url('admin/promos/'.$promo->id.'/edit') }}" class="btn btn-sm btn-info" title="Edit Promo"><i class="fas fa-edit"></i> Edit</a>
                            </td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>Promo Name</th>
                          <th>Promo Code</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Max Amount</th>
                          <th>Valid Date</th>
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
          
          $("#promos_table").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "buttons": [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    }
                },
                'colvis'
            ],
          }).buttons().container().appendTo('#promos_table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection