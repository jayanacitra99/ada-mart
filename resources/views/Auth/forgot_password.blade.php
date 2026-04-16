<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdaMart | Forgot Password</title>
<link rel="icon" href="{{ asset('logomark.ico') }}" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/toastr/toastr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .gradient-custom-2 {
    /* fallback for old browsers */
    background: #fccb90;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right top, #0a894c, #497d25, #676e00, #7e5c00, #8f4600, #a04800, #b14800, #c34800, #d66c00, #e78f00, #f5b215, #ffd630);

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right top, #0a894c, #497d25, #676e00, #7e5c00, #8f4600, #a04800, #b14800, #c34800, #d66c00, #e78f00, #f5b215, #ffd630);
    }

    @media (min-width: 768px) {
    .gradient-form {
    height: 100vh !important;
    }
    }
    @media (min-width: 769px) {
    .gradient-custom-2 {
    border-top-right-radius: .3rem;
    border-bottom-right-radius: .3rem;
    }
  }
  </style>
</head>
<body class="">
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">
  
                <div class="text-center">
                  <img src="{{asset('adamart-logo.png')}}" style="width: 65px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">Forgot Password</h4>
                </div>
                <form action="{{route('password.email')}}" method="post">
                  @csrf
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>
                      <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block text-bold" style="background-color: #c00000">Request new password</button>
                      </div>
                      <!-- /.col -->
                    </div>
                </form>
                <div class="text-center pt-1 mb-5 pb-1">
                  <a href="{{url('/login')}}" style="color: #c00000">Login</a>
                </div>

                <div class="d-flex align-items-center justify-content-center pb-4">
                  <a href="{{url('/register')}}" class="text-center" style="color: #c00000">Register a new membership</a>
                </div>
              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <img src="{{asset('adamart-logo.png')}}" style="width: 100%;" alt="logo">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- jQuery -->
<script src="{{asset('')}}adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('')}}adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('')}}adminlte/dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="{{asset('')}}adminlte/plugins/toastr/toastr.min.js"></script>
@if (session('notif'))
  <script>
    toastr.{{session('notif')['type']}}('{{session('notif')['text']}}');
  </script>
@endif
@if ($errors->any())
    <script>
        $(document).ready(function(){
            var errors = @json($errors->all());
            errors.forEach(element => {
              toastr.warning(element)
            });
        });
    </script>
@endif
</body>
</html>
