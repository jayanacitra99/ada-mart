@extends('Customer.layout')
@section('title')
    KaromahJaya - My Account
@endsection
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/daterangepicker/daterangepicker.css">
    <style>
        .nav-tabs .nav-link {
            color: black;
            font-weight: normal;
            background-color: #fff;
        }
        .nav-tabs .nav-link.active {
            background-color: #c00000;
            color: white;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid pt-lg-5">
    <div class="row justify-content-center">
        <div class="col-10 p-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-12 mb-3">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline" style="border-color: #c00000">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{$user->profile_image}}"
                                        alt="{{$user->name}}">
                                </div>

                                <h3 class="profile-username text-center">{{$user->name}}</h3>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                    <b>Email</b> <span class="float-right">{{$user->email}}</span>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Phone</b> <span class="float-right">{{$user->phone}}</span>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Birth Date</b> <span class="float-right">{{$user->birth_date ? Carbon\Carbon::parse($user->birth_date)->format('d M Y'):'-'}}</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="nav flex-column nav-tabs round" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link" id="vert-tabs-account-tab" data-toggle="pill" href="#vert-tabs-account" role="tab" aria-controls="vert-tabs-account" aria-selected="true">Account</a>
                            <a class="nav-link" id="vert-tabs-address-tab" data-toggle="pill" href="#vert-tabs-address" role="tab" aria-controls="vert-tabs-address" aria-selected="true">Addresses</a>
                            <a class="nav-link active" id="vert-tabs-orders-tab" data-toggle="pill" href="#vert-tabs-orders" role="tab" aria-controls="vert-tabs-orders" aria-selected="false">My Orders</a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-12">
                        <div class="tab-content card" id="vert-tabs-tabContent">
                            <div class="tab-pane text-left fade card-body" id="vert-tabs-account" role="tabpanel" aria-labelledby="vert-tabs-account-tab">
                                <div class="row">
                                    <div class="col-lg-6 col-12 border-right border-gray-800">
                                        <form method="POST" action="{{ route('account.updateProfile') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group col-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-12">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                                                </div>
                                                <div class="form-group col-lg-6 col-12">
                                                    <label for="phone">Phone</label>
                                                    <input type="tel" class="form-control" id="phone" name="phone" pattern="0[0-9]{8,12}" value="{{$user->phone}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="form-group">
                                                        <img id="imagePreview" class="img-circle" src="{{asset($user->profile_image)}}" alt="Image Preview" style="max-width: 200px;">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="profile_image">Profile Image</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" accept="image/*" name="profile_image" id="profile_image" onchange="previewImage(event)">
                                                                <label class="custom-file-label" for="profile_image" id="imageLabel">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-lg-6 col-12">
                                                    <label>Birth Date:</label>
                                                    <div class="input-group date" id="birth_date" data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input" name="birth_date" data-target="#birth_date"/>
                                                        <div class="input-group-append" data-target="#birth_date" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn text-white text-bold" name="submit" style="background-color: #c00000;">Update</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="text-center">
                                            <strong>Change Password</strong>
                                        </div>
                                        <form method="post" action="{{url('admin/users/'.$user->id.'/update-password')}}" id="change_password_form">
                                            @csrf
                                            <div class="form-group col">
                                                <label for="old_password">Current Password</label>
                                                <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password" required>
                                            </div>
                                            <div class="form-group col">
                                                <label for="password">New Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
                                            </div>
                                            <div class="form-group col">
                                                <label for="password_confirmation">Retype Password</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Retype Password" required>
                                            </div>
                                            <button type="button" class="btn text-white text-bold" id="submit_button" style="background-color: #c00000">Update Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane text-left fade card-body" id="vert-tabs-address" role="tabpanel" aria-labelledby="vert-tabs-address-tab">
                                <div class="border-bottom d-flex justify-content-end">
                                    <button class="btn btn-outline-danger" id="btn-add-address"><i class="fas fa-plus-square mr-2"></i>Add Address</button>
                                </div>
                                <div class="w-100">
                                    @if ($addresses->count() == 0)
                                        <div class="text-center">
                                            <strong>You don't have any address registered</strong>
                                        </div>
                                    @else
                                        <table class="table table-responsive-md w-100" id="addresses_table">
                                            <thead>
                                                <tr>
                                                    <th>Contact</th>
                                                    <th>Address</th>
                                                    <th>Default</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($addresses as $address)
                                                    <tr>
                                                        <td>
                                                            <div><strong class="text-bold">{{$address->recipient_name}}</strong></div>
                                                            <div><strong class="text-bold">{{$address->recipient_phone_number}}</strong></div>
                                                        </td>
                                                        <td>
                                                            <span class="font-weight-light">{{$address->combined_address}}</span>
                                                        </td>
                                                        <td>
                                                            <div class="address-field-default" data-address-id="{{ $address->id }}">
                                                                @if (!$address->is_default)
                                                                    <button class="btn btn-sm btn-info set-default-address" data-address-id="{{ $address->id }}">
                                                                        <i class="fas fa-thumbtack mr-2"></i> Set as Default
                                                                    </button>
                                                                @else
                                                                    <span><i class="fas fa-thumbtack text-danger text-center"></i></span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade card-body show active" id="vert-tabs-orders" role="tabpanel" aria-labelledby="vert-tabs-orders-tab">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item col-md-6 col-sm-12 col-lg-3 text-center text-bold">
                                        <a class="nav-link active" id="custom-tabs-one-billed-tab" data-toggle="pill" href="#custom-tabs-one-billed" role="tab" aria-controls="custom-tabs-one-billed" aria-selected="true">Billed</a>
                                    </li>
                                    <li class="nav-item col-md-6 col-sm-12 col-lg-3 text-center text-bold">
                                        <a class="nav-link" id="custom-tabs-one-paid-tab" data-toggle="pill" href="#custom-tabs-one-paid" role="tab" aria-controls="custom-tabs-one-paid" aria-selected="false">Ongoing</a>
                                    </li>
                                    <li class="nav-item col-md-6 col-sm-12 col-lg-3 text-center text-bold">
                                        <a class="nav-link" id="custom-tabs-one-completed-tab" data-toggle="pill" href="#custom-tabs-one-completed" role="tab" aria-controls="custom-tabs-one-completed" aria-selected="false">Completed</a>
                                    </li>
                                    <li class="nav-item col-md-6 col-sm-12 col-lg-3 text-center text-bold">
                                        <a class="nav-link" id="custom-tabs-one-canceled-tab" data-toggle="pill" href="#custom-tabs-one-canceled" role="tab" aria-controls="custom-tabs-one-canceled" aria-selected="false">Canceled</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active mt-4" id="custom-tabs-one-billed" role="tabpanel" aria-labelledby="custom-tabs-one-billed-tab">
                                        @include('Customer.orders_table', ['orders' => $billed_orders, 'buttonText' => 'Pay Now', 'type' => 'billed'])
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-paid" role="tabpanel" aria-labelledby="custom-tabs-one-paid-tab">
                                        @include('Customer.orders_table', ['orders' => $paid_orders, 'buttonText' => 'Track Order', 'type' => 'paid'])
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-completed" role="tabpanel" aria-labelledby="custom-tabs-one-completed-tab">
                                        @include('Customer.orders_table', ['orders' => $completed_orders, 'buttonText' => 'Check Invoice', 'type' => 'completed'])
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-canceled" role="tabpanel" aria-labelledby="custom-tabs-one-canceled-tab">
                                        @include('Customer.orders_table', ['orders' => $canceled_orders, 'buttonText' => 'Reorder', 'type' => 'canceled'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->
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
    $(document).ready(function(){
        $('#orders_table').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
        $('#addresses_table').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
        $(document).on('click','#submit_button',function(e) {
            e.preventDefault(); // Prevent the default form submission

            let oldPassword = $('#old_password').val();
            let newPassword = $('#password').val();
            let confirmPassword = $('#password_confirmation').val();

            $.ajax({
                url: "{{ url('update-password/'.auth()->user()->id) }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    old_password: oldPassword,
                    password: newPassword,
                    password_confirmation: confirmPassword
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: response.notif.text,
                    });
                    $('#old_password').val('');
                    $('#password').val('');
                    $('#password_confirmation').val('');
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    let errors = JSON.parse(xhr.responseText).errors;
                    let passwords = errors.password;
                    passwords.forEach(element => {
                        toastr.error(element);
                    });
                }
            });
        });
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('imagePreview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
            // Update the label text with the selected image name
            var fileName = event.target.files[0].name;
            document.getElementById('imageLabel').innerText = fileName;
        }
        var birthDateValue = "{{ $user->birth_date}}";
        $('#birth_date').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: birthDateValue
        });
        // Open datepicker when clicking on the input field
        $('#birth_date').on('click', function() {
            $(this).datetimepicker('show');
        });
        $('#btn-add-address').click(function() {
            let modal = $('#myModal');
            let url = "{{url('/add-address-page')}}";
            modal.find('.modal-content').empty();
            modal.find('.modal-content').load(url, function(result){
                modal.modal('show');
            });
        });

        $(document).on('click','#addNewAddress',function() {
            const recipientName = $('#recipientName').val();
            const phoneNumber = $('#phoneNumber').val();
            const fullAddress = $('#fullAddress').val();
            const city = $('#city').val();
            const postalCode = $('#postalCode').val();
            const additionalInfo = $('#additionalInfo').val();
            const setDefault = $('#setDefault').is(':checked');

            const addressData = {
                user_id: {{auth()->user()->id}},
                recipient_name: recipientName,
                recipient_phone_number: phoneNumber,
                full_address: fullAddress,
                city: city,
                postal_code: postalCode,
                additional_instructions: additionalInfo,
                is_default: setDefault
            };

            $.ajax({
                type: 'POST',
                url: '{{url("create-address")}}',  // Use the correct server endpoint
                contentType: 'application/json',
                data: JSON.stringify(addressData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    });
                    let modal = $('#myModal');
                    modal.modal('hide');
                    window.location.href = "{{url('my-account')}}";
                },
                error: function(error) {
                    console.error('Error:', error);
                    Toast.fire({
                        icon: 'warning',
                        title: 'Error:', error,
                    });
                }
            });
        });
        $(document).on('click','.set-default-address',function() {
            var button = $(this);
            var addressId = button.data('address-id');

            $.ajax({
                type: 'POST',
                url: '{{ route('address.setDefault') }}',
                data: {
                    address_id: addressId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('.address-field-default').each(function() {
                            var div = $(this);
                            var spanHtml = '<span><i class="fas fa-thumbtack text-danger text-center"></i></span>';
                            if (div.data('address-id') == addressId) {
                                div.html(spanHtml);
                            } else {
                                div.html('<button class="btn btn-sm btn-info set-default-address" data-address-id="' + div.data('address-id') + '"><i class="fas fa-thumbtack mr-2"></i> Set as Default</button>');
                            }
                        });
                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        });
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                    Toast.fire({
                        icon: 'warning',
                        title: 'An error occurred. Please try again.',
                    });
                }
            });
        });

    })
</script>
@endsection
