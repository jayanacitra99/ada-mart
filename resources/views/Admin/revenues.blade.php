@extends('Admin.layout')
@section('title')
Completed Orders
@endsection
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/daterangepicker/daterangepicker.css">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Completed Orders</h1>
            </div>
            
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                <li class="breadcrumb-item active">All Completed Orders</li>
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
                    <h3 class="card-title">All Completed Orders</h3>
                    <div class="form-group">
                      <label>Date range:</label>
    
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control float-right" id="date-filter">
                        <button class="btn btn-sm btn-danger" id="reset-filter">Reset</button>
                      </div>
                      <!-- /.input group -->
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="orders_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>No.</th>
                          <th>Total</th>
                          <th>Paid At</th>
                          <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                          $no = 1;
                      @endphp
                      @foreach ($orders as $order)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $order->total }}</td>
                            <td>
                              @if (!is_null($order->paid_at))
                                  {{Carbon\Carbon::parse($order->paid_at)->format('Y-m-d')}}
                              @endif  
                            </td>
                            <td>{{ Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>Total</th>
                          <th>Paid At</th>
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
    <!-- date-range-picker -->
    <script src="{{asset('')}}adminlte/plugins/daterangepicker/daterangepicker.js"></script>

    {{-- <script>
        $(document).ready(function () {
          $('#date-filter').daterangepicker();
          $("#orders_table").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "buttons": [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        footer: true,
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        footer: true,
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        footer: true,
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        footer: true,
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        footer: true,
                    }
                },
                'colvis'
            ],
          }).buttons().container().appendTo('#orders_table_wrapper .col-md-6:eq(0)');
        });
    </script> --}}
    <script>
      $(document).ready(function () {
          // Initialize Date Range Picker
          $('#date-filter').daterangepicker({
              autoUpdateInput: false,
              locale: {
                  cancelLabel: 'Clear'
              }
          });
  
          // Initialize DataTable
          var table = $("#orders_table").DataTable({
              "responsive": true,
              "lengthChange": true,
              "autoWidth": false,
              "footerCallback": function (row, data, start, end, display) {
                  var api = this.api();
                  var total = api.column(1, { search: 'applied' }).data().reduce(function (a, b) {
                      return parseFloat(a) + parseFloat(b);
                  }, 0);
                  $(api.column(1).footer()).html('Rp.' + total);
              },
              "buttons": [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        footer: true,
                    },
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        var footerRow = '<row>';
                        
                        $('#orders_table tfoot th').each(function () {
                            footerRow += '<c t="inlineStr"><is><t>' + $(this).text() + '</t></is></c>';
                        });
                        
                        footerRow += '</row>';
                        
                        $('sheetData', sheet).append(footerRow);
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        footer: true,
                    },
                    customize: function (doc) {
                        var lastRow = doc.content[1].table.body.length - 1;
                        doc.content[1].table.body[lastRow] = $('#orders_table tfoot th').map(function () {
                            return $(this).text();
                        }).get();
                    }
                },
                
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        footer: true,
                    },
                    customize: function (win) {
                        $(win.document.body).find('table').append($('#orders_table tfoot').clone());
                    }
                },
                'colvis'
              ],
          });

          table.buttons().container().appendTo('#orders_table_wrapper .col-md-6:eq(0)');
  
          // Apply date range filter
          $('#date-filter').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
              table.columns(2).search(
                  picker.startDate.format('YYYY-MM-DD') + '|' + picker.endDate.format('YYYY-MM-DD'), true, false
              ).draw();
          });
  
          // Clear date range filter
          $('#date-filter').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
              table.columns(2).search('').draw();
          });
  
          // Reset filter
          $('#reset-filter').click(function() {
              $('#date-filter').val('');
              table.columns(2).search('').draw();
          });
      });
    </script>
  
@endsection