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
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/toastr/toastr.min.css">
  <!-- sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    a {
      color: inherit;
    }
    a:hover {
      color: #c00000;
    }
    .login-or-register {
        background-color: #c00000;
        color: white;
        transition: background-color 0.3s, color 0.3s;
    }
     .login-or-register:hover {
        background-color: #ffcb39;
        color: #c00000;
    }
    .btn-custom {
        border-color: #c00000;
        background-color: white;
        color: #c00000;
    }
    .btn-custom.active,
    .btn-custom:active {
        border-color: #ffcb39;
        background-color: #c00000;
        color: #ffcb39;
    }
    .btn-custom.disabled {
        pointer-events: none;
        opacity: 0.65;
    }
    .product-name {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 3em; /* Adjust based on your line-height */
        line-height: 1.5em; /* Adjust this value to match your design */
    }
  </style>
  @yield('styles')
</head>
{{-- <body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed"> --}}
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  @if(Route::is('home'))
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{asset('')}}adamart-logo.png" alt="AdaMartLogo" height="100" width="100">
    </div>
  @endif
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-lg navbar-light" style="background-color: #c00000">
    <div class="container-fluid px-lg-3">
      <a href="{{route('home')}}" class="navbar-brand pr-lg-2">
        <div class="d-flex align-items-center">
          <img src="{{asset('adamart-logo.png')}}" alt="AdaMart Logo" class="brand-image mr-2" style="object-fit: contain; max-width: 25%; height:auto; max-height: 60px">
          <h1 class="brand-image text-bold" style="object-fit: contain; max-width: 75%; height:auto; max-height: 40px; color:#ffcb39"> Karomah Jaya </h1>
        </div>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-around" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item" style="{{Request::is('/') ? 'background-color:#ffcb39' : ''}}">
            <a href="{{route('home')}}" class="nav-link text-bold {{Request::is('/') ? 'text-black' : 'text-white'}}">Home</a>
          </li>
          <li class="nav-item" style="{{Request::is('all-products') ? 'background-color:#ffcb39' : ''}}">
            <a href="{{route('all-products')}}" class="nav-link text-bold {{Request::is('all-products') ? 'text-black' : 'text-white'}}">Products</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-white text-bold">Category</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              @php
                $categories = App\Models\Categories::with('productCategories.product')
                              ->whereHas('productCategories.product')
                              ->get();
              @endphp
              @foreach ($categories as $category)
                <li><a href="{{url('/all-products?category_id='.$category->id)}}" class="dropdown-item">{{$category->name}}</a></li>
                <li class="dropdown-divider"></li>
              @endforeach
            </ul>
          </li>
        </ul>
        <form class="form-inline ml-0" method="GET" action="{{ route('all-products') }}">
          <div class="input-group input-group-sm w-100">
            <input class="form-control text-black" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
            @if (isset($categoryId))
              <input type="hidden" name="category_id" value="{{$categoryId}}">
            @endif
            @if (isset($isPromo) and $isPromo)
              <input type="hidden" name="promo" value="{{$isPromo}}">
            @endif
            <div class="input-group-append">
              <button class="btn btn-navbar" style="background-color: #ffcb39" type="submit">
                <i class="fas fa-search text-black"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="d-flex justify-content-center align-items-center">
        <ul class="navbar-nav">
          @if (auth()->check())
            <li class="nav-item">
              <a class="nav-link" href="{{url('shopping-carts/'.auth()->user()->id)}}">
                <i class="fas fa-shopping-cart text-white"></i>
                <span class="badge badge-warning navbar-badge" id="shopping-cart-badge">{{auth()->user()->shoppingCarts->count()}}</span>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-user text-white"></i></a>
              <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="{{url('my-account')}}" class="dropdown-item">My Account</a></li>
                <li>
                  <form action="{{url('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger" name="submit">Log Out <i class="fas fa-sign-out-alt ml-2"></i></button>
                  </form>
                </li>
              </ul>
            </li>
          @else
            <li class="nav-item">
              <a href="{{url('login')}}" class="btn text-bold border border-white login-or-register text-truncate"><i class="fas fa-sign-in-alt mr-2"></i> Login/Register</a>
            </li>
          @endif
        </ul>
        <div class="d-flex justify-content-center align-items-center ml-3">
          <div class="justify-content-center text-nowrap">
            <div><span class="text-white text-bold">Selamat Datang,</span></div>
            <div><span class="text-white text-bold">Selamat Berbelanja</span></div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="{{asset('')}}adminlte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('')}}adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
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
<!-- Toastr -->
<script src="{{asset('')}}adminlte/plugins/toastr/toastr.min.js"></script>

@yield('scripts')

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
  $(document).ready(function() {
    $(document).on('click', '.btn-buy-now, .btn-cart-plus', function(event) {
              event.preventDefault();
              let action = $(this).data('action');
              let confirmButtonText = action === 'order' ? 'Beli Sekarang' : 'Keranjang';
              let productDetails = JSON.parse($(this).attr('data-product-details'));

              @if (Auth::check())
                let userId = {{ auth()->user()->id }};
                let initialDetail = productDetails.find(detail => detail.quantity > 0) || productDetails[0];
                let productDetailsHtml = '';

                productDetails.forEach(function(detail) {
                    const isAddToCart = action === 'cart';
                    let maxQuantity = detail.quantity;
                    if (isAddToCart) {
                        let cartQuantity = detail.shopping_carts.filter(cart => cart.user_id === userId).reduce((sum, cart) => sum + cart.quantity, 0);
                        maxQuantity -= cartQuantity;
                    }
                    const isDisabled = maxQuantity <= 0;
                    productDetailsHtml += `
                        <label class="btn btn-block btn-custom ${isDisabled ? 'disabled' : ''}">
                            <input type="radio" name="productDetail" value="${detail.id}" id="productDetail${detail.id}" autocomplete="off" ${isDisabled ? 'disabled' : ''}>
                            ${detail.unit_type.toUpperCase()}
                        </label>
                    `;
                });

                  Swal.fire({
                      title: 'Select Product Detail',
                      html: `
                          <form id="productForm">
                              <div class="btn-group-vertical btn-group-lg btn-group-toggle" data-toggle="buttons">
                                  ${productDetailsHtml}
                              </div>
                              <div class="mt-2">
                                  <span>Price: <b>Rp <span id="productPrice">${initialDetail.price}</span></b></span>
                              </div>
                              <div class="mt-2">
                                  <label for="quantity">Quantity</label>
                                  <div class="d-flex justify-content-center">
                                      <input type="number" id="quantity" name="quantity" class="form-control col-7" min="1" max="${initialDetail.quantity}" value="1">
                                  </div>
                              </div>
                          </form>
                      `,
                      showCancelButton: true,
                      confirmButtonText: confirmButtonText,
                      preConfirm: () => {
                          const selectedDetail = document.querySelector('input[name="productDetail"]:checked');
                          const quantity = document.getElementById('quantity').value;

                          if (!selectedDetail) {
                              Swal.showValidationMessage('Please select a product detail');
                              return false;
                          }

                          return {
                              productDetailId: selectedDetail.value,
                              quantity: quantity
                          };
                      }
                  }).then((result) => {
                      if (result.isConfirmed) {
                          const formData = result.value;
                          if (action === 'cart') {
                            $.ajax({
                              url: '{{ route("cart.add") }}',
                              method: 'POST',
                              data: {
                                  unit_type   : formData.productDetailId,
                                  quantity    : formData.quantity,
                                  user_id     : {{auth()->check() ? auth()->user()->id : 'null'}},
                                  _token: '{{ csrf_token() }}'
                              },
                              success: function(response) {
                                  if(response.success) {
                                      let badge = $('#shopping-cart-badge');
                                      badge.text(response.count_cart);
                                      Toast.fire({
                                          icon: 'success',
                                          title: response.message,
                                      });
                                  } else {
                                      Toast.fire({
                                          icon: 'warning',
                                          title: response.message,
                                      });
                                  }
                              },
                              error: function(xhr, status, error) {
                                  if (xhr.status === 401) { // Unauthorized
                                      Swal.fire({
                                          title: '{{auth()->check() ? "You Still Login as Admin":"Unauthenticated"}}',
                                          text: '{{auth()->check() ? "Please Logout First then use Customer Account":"Please Login First"}}',
                                          icon: 'warning',
                                          showCancelButton: true,
                                          confirmButtonColor: '{{auth()->check() ? "#c00000":"#3085d6"}}',
                                          confirmButtonText: '{{auth()->check() ? "Logout Now":"Login Now"}}',
                                      }).then((result) => {
                                          if (result.isConfirmed) {
                                            if ('{{auth()->check()}}') {
                                              $.ajax({
                                                  url: '{{ url('logout') }}', // The URL to send the request to
                                                  method: 'POST',
                                                  data: {
                                                      _token: '{{ csrf_token() }}' // Include the CSRF token
                                                  },
                                                  success: function(response){
                                                      // Handle success (e.g., redirect to the login page, show a success message, etc.)
                                                      window.location.href = '{{ route("login") }}';
                                                  },
                                                  error: function(xhr){
                                                      // Handle error (e.g., show an error message)
                                                      alert('An error occurred while logging out. Please try again.');
                                                  }
                                              });
                                            } else {
                                              window.location.href = '{{ route("login") }}';
                                            }
                                          }
                                      })
                                  } else {
                                      Toast.fire({
                                          icon: 'warning',
                                          title: JSON.parse(xhr.responseText).message ?? 'Failed to add cart',
                                      });
                                  }
                              }
                            });
                          } else if (action === 'order'){
                            let dataToEncrypt = JSON.stringify({ type: 'direct', product: formData });
                            $.ajax({
                                url: "{{ url('/encrypt-data') }}",
                                method: 'POST',
                                data: {
                                    data: dataToEncrypt,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    window.location.href = "{{ url('/check-order') }}?data=" + response.encryptedData;
                                }
                            });
                          }
                      }
                  });

                  document.querySelectorAll('input[name="productDetail"]').forEach(function(radio) {
                    radio.addEventListener('change', function() {
                        const selectedDetail = productDetails.find(detail => detail.id == this.value);
                        let maxQuantity = selectedDetail.quantity;
                        let minOrder = selectedDetail.min_order;
                        if(action === 'cart'){
                          let cartQuantity = selectedDetail.shopping_carts.filter(cart => cart.user_id === userId).reduce((sum, cart) => sum + cart.quantity, 0);
                          maxQuantity = selectedDetail.quantity - cartQuantity;
                        }
                        document.getElementById('productPrice').textContent = selectedDetail.price;
                        document.getElementById('quantity').max = maxQuantity;
                        document.getElementById('quantity').min = minOrder;
                        document.getElementById('quantity').value = minOrder;
                        // document.getElementById('quantityLeft').textContent = `(${selectedDetail.quantity} left)`;
                    });
                });
              @else
                  Swal.fire({
                      title: 'Not Logged In',
                      text: 'You need to log in to perform this action.',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Log In',
                      cancelButtonText: 'Cancel'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          window.location.href = '/login';
                      }
                  });
              @endif
    });
  });
  function markAsRead(notificationID, dropdownID) {
        // Send an AJAX request to mark the notification as read
        $.ajax({
            url: "{{url('admin/notifications/mark-as-read')}}",
            type: 'POST',
            data: { notifID: notificationID, _token: '{{ csrf_token() }}' },
            success: function(response) {
                $('#dropdown_'+dropdownID).html(response);
            }
        });
    }
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
                    error : function(error){
                      Toast.fire({
                          icon: "warning",
                          title: JSON.parse(error.responseText).message ?? "Delete Product Failed",
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
