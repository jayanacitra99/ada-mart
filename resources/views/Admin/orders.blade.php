@extends('Admin.layout')
@section('title')
    Orders
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
              <h1>Orders</h1>
            </div>
            
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
                <li class="breadcrumb-item active">All Orders</li>
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
                    <h3 class="card-title">All Orders</h3>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="orders_table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>No.</th>
                          <th>Order ID</th>
                          <th>User Name</th>
                          <th>Promo</th>
                          <th>Status</th>
                          <th>Total</th>
                          <th>Billed At</th>
                          <th>Paid At</th>
                          <th>Created at</th>
                          <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                          $no = 1;
                      @endphp
                      @foreach ($orders as $order)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->promo?->promo_detail }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                              @if ($order->promo)
                                @if ($order->promo->active)
                                  <s>{{$order->total}}</s> {{$order->total_final}}
                                @else
                                  {{ $order->total }}
                                @endif
                              @else
                                {{ $order->total }}
                              @endif
                            </td>
                            <td>{{ Carbon\Carbon::parse($order->billed_at)->format('D, d M Y, H:i:s') }}</td>
                            <td>
                              @if (!is_null($order->paid_at))
                                  {{Carbon\Carbon::parse($order->paid_at)->format('D, d M Y, H:i:s')}}
                              @endif  
                            </td>
                            <td>{{ Carbon\Carbon::parse($order->created_at)->format('D, d M Y, H:i:s') }}</td>
                            <td class="text-center row">
                                <a actionURL="{{ url('admin/orders/'.$order->id) }}" class="btn btn-sm btn-danger buttonDelete col-4" title="Delete Order"><i class="fas fa-trash"></i> Delete</a>                          
                                @if (!is_null($order->paid_at))
                                <button href="#" class="btn btn-sm btn-warning detailPayment col-4" data-show-detail="{{url('admin/payments/'.$order->id)}}" title="Detail Payment"><i class="fas fa-money-bill"></i> Payment</button>
                                @endif  
                                @if ($order->status != 'billed' and $order->status != 'canceled')
                                <button href="#" class="btn btn-sm btn-info detailShipping col-4" data-show-detail="{{url('admin/shippings/'.$order->id)}}" title="Detail Shipping"><i class="fas fa-shipping-fast"></i> Shipping</button>
                                @endif  
                                <button href="#" class="btn btn-sm btn-secondary detailOrder col-4" data-show-detail="{{url('admin/orders/'.$order->id)}}" title="Detail Order"><i class="fas fa-search"></i> Detail</button>
                                <button class="btn btn-sm btn-success detailProfile col-4" data-from="order" data-toggle="modal" data-show-profile="{{url('admin/users/'.$order->user_id)}}"><i class="fas fa-user mr-2"></i> Customer</button>
                            </td>
                          </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                          <th>No.</th>
                          <th>Order ID</th>
                          <th>User Name</th>
                          <th>Promo</th>
                          <th>Status</th>
                          <th>Total</th>
                          <th>Billed At</th>
                          <th>Paid At</th>
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
          $(document).on('click','.detailOrder',function(){
              let modal = $('#myModal');
              let url = $(this).data('show-detail');
              modal.find('.modal-content').empty();
              modal.find('.modal-content').load(url, function(result){
                modal.modal('show');
              });
          });
          $(document).on('click','.detailPayment',function(){
              let modal = $('#myModal');
              let url = $(this).data('show-detail');
              modal.find('.modal-content').empty();
              modal.find('.modal-content').load(url, function(result){
                modal.modal('show');
              });
          });

          $(document).on('click','.detailShipping',function(){
              let modal = $('#myModal');
              let url = $(this).data('show-detail');
              modal.find('.modal-content').empty();
              modal.find('.modal-content').load(url, function(result){
                modal.modal('show');
              });
          });
          
          $("#orders_table").DataTable({
            "responsive": true, 
            "lengthChange": true, 
            "autoWidth": false,
            "order": [[ 0, "desc" ]],
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
          }).buttons().container().appendTo('#orders_table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection