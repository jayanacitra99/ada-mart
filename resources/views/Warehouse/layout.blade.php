<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
<link rel="icon" href="{{ asset('logomark.ico') }}" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/dist/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    a {
      color: inherit;
    }
    a:hover {
      color: #c00000;
    }
  </style>
  @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('')}}adamart-logo.png" alt="AdaMartLogo" height="100" width="100">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <div class="nav-link" data-toggle="dropdown" href="#">
            <div class="user-panel d-flex">
                <span class="d-block">{{auth()->user()->name}}</span>
                <div class="image">
                  <img src="{{asset(auth()->user()->profile_image ?? 'users_profile_image/man-1.png')}}" class="img-circle" alt="User Image">
                </div>
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Users Menu</span>
            <div class="dropdown-divider"></div>
            <button class="btn btn-sm btn-info detailProfile dropdown-item" data-toggle="modal" data-show-profile="{{url('admin/users/'.auth()->user()->id)}}"><i class="fas fa-user mr-2"></i> User Profile</button>
            <div class="dropdown-divider"></div>
            <div class="d-flex justify-content-center">
                <form action="{{url('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm bg-gradient-danger" name="submit"><i class="fas fa-sign-out-alt mr-2"></i>Log Out</button>
                </form>
            </div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-blue elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('warehouse-admin')}}" class="brand-link">
      <img src="{{asset('')}}adamart-logo.png" alt="AdaMart Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-bold">KaromahJaya</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{url('warehouse-admin/orders')}}" class="nav-link {{Request::is('warehouse-admin/orders*') ? 'active':''}}">
              <i class="fas fa-hand-holding-usd"></i>
              <p>
                Orders
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('warehouse-admin/order-histories')}}" class="nav-link {{Request::is('warehouse-admin/order-histories*') ? 'active':''}}">
              <i class="fas fa-history"></i>
              <p>
                Order Histories
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="{{asset('')}}adminlte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('')}}adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>

@yield('scripts')

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('')}}adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{asset('')}}adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{asset('')}}adminlte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{asset('')}}adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{asset('')}}adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('')}}adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{asset('')}}adminlte/plugins/moment/moment.min.js"></script>
<script src="{{asset('')}}adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('')}}adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{asset('')}}adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('')}}adminlte/dist/js/adminlte.js"></script>

<script>
  const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
  });
</script>
@if ($errors->any())
    <script>
        $(document).ready(function(){
            var errors = @json($errors->all());
            var errorMessage = errors.join('<br>');
              Toast.fire({
                  icon: 'error',
                  title: 'Validation Error',
                  html: errorMessage,
              });
        });
    </script>
@endif
@if (session('notif'))
		<script>
			$(document).ready(function(){
        Toast.fire({
            icon: "{{ session('notif')['type'] }}",
            title:"{{ session('notif')['text'] }}",
        });
			})
		</script>
	@endif
@yield('end_scripts')
<script>
  $(document).ready(function(){
      $(document).on('click','.detailProfile',function(){
          let modal = $('#myModal');
          let url = $(this).data('show-profile');
          modal.find('.modal-content').empty();
          modal.find('.modal-content').load(url, function(result){
          modal.modal('show');
          });
      });
      $(document).on('click','.updateProfile',function(){
          let modal = $('#myModal');
          let url = $(this).data('update-profile');
          modal.find('.modal-content').empty();
          modal.find('.modal-content').load(url, function(result){
          modal.modal('show');
          });
      });
      $(document).on('click','.changePassword',function(){
          let modal = $('#myModal');
          let url = $(this).data('change-password');
          modal.find('.modal-content').empty();
          modal.find('.modal-content').load(url, function(result){
          modal.modal('show');
          });
      });
      $(document).on('click','.buttonDelete',function(){
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  var actionURL = $(this).attr('actionURL');
                  $.ajax({
                    url : actionURL,
                    type : 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    dataType : 'json',
                    success : function(result){
                      window.location.reload();
                      Toast.fire({
                          icon: "success",
                          title:"Product Deleted",
                      });
                    },
                    error : function(result){
                      Toast.fire({
                          icon: "warning",
                          title:"Delete Product Failed",
                      });
                    }
                  });
              }
          })
      });

  });
</script>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">

      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</body>
</html>
