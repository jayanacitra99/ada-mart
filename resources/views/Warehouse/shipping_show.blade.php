<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Order ID : {{$order->id}}</h3>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-striped" id="order_details_table">
                    <thead>
                        <tr>
                            <th>Shipping Number</th>
                            <th>Type</th>
                            <th>Destination</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                            <th>Proof Image</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{$shipping->shipping_number}}</td>
                                <td>{{$shipping->type}}</td>
                                <td>{{$shipping->address->full_address ?? '-'}}</td>
                                <td>Rp.{{$shipping->subtotal}}</td>
                                <td>
                                    @if ($shipping->status == 'waiting')
                                        Preparing
                                    @elseif($shipping->status == 'ongoing')
                                        Package Ready
                                        <a href="{{ url('admin/generate-invoice/'.$shipping->id) }}" class="btn btn-sm btn-success" target="_blank" title="Print Invoice"><i class="fas fa-receipt"></i> PRINT </a>
                                    @elseif($shipping->status == 'arrived' | $shipping->status == 'completed')
                                        Completed
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset($shipping->proof_image) }}" target="_blank">
                                        <img src="{{ asset($shipping->proof_image) }}" alt="{{ basename($shipping->proof_image) }}" class="img-size-64">
                                    </a>
                                </td>
                                <td class="text-center" >
                                    @if ($order->status != 'completed')
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info">Action</button>
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                          <a class="dropdown-item" onclick="updateShipping('waiting')">Preparing</a>
                                          <a class="dropdown-item" onclick="updateShipping('ongoing')">Package Ready</a>
                                          <a class="dropdown-item" onclick="updateShipping('arrived')">Completed</a>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
<!-- /.col -->
</div>
<!-- /.row -->
<script>
    $("#order_details_table").DataTable({
        "responsive": true, 
        "searching" : false,
        "lengthChange": false, 
        "autoWidth": false,
    });
</script>
<!-- /.row -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 library -->

<script>
    function updateShipping(statusShipping) {

        // Check if status is completed
        if (statusShipping === 'arrived') {
            Swal.fire({
                title: 'Upload Proof Image',
                html: '<input type="file" id="proofImage" accept="image/*">' +
                      '<img id="previewImage" style="display:none; max-width: 100%; max-height: 200px; margin-top: 10px;">', // Image preview container
                showCancelButton: true,
                confirmButtonText: 'Submit',
                preConfirm: () => {
                    const file = document.getElementById('proofImage').files[0];
                    if (!file) {
                        Swal.showValidationMessage('Please select a file');
                    }
                    return file;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const file = result.value;
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        Swal.fire({
                            title: 'Preview',
                            imageUrl: e.target.result,
                            imageAlt: 'Uploaded Image',
                            showCancelButton: true,
                            confirmButtonText: 'Confirm',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const formData = new FormData();
                                formData.append('proof_image', file);
                                formData.append('status', statusShipping); // Add status
                                formData.append('_method', 'PATCH'); // Add status
                                // Add additional data including proof image
                                $.ajax({
                                    url: "{{url('warehouse-admin/orders/'.$shipping->id)}}", // Replace with your endpoint URL
                                    type: 'POST', // Change this to 'PATCH'
                                    headers: {
                                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                                    },
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        if (response.notif) {
                                            Toast.fire({
                                                icon: 'success',
                                                title: response.notif.text,
                                            });
                                            let modal = $('#myModal');
                                            modal.modal('hide');
                                            if(statusShipping === 'arrived'){
                                                window.location.reload();
                                            }
                                        }
                                    },
                                    error: function(error) {
                                        
                                        Toast.fire({
                                            icon: 'error',
                                            title: JSON.parse(error.responseText).message ?? JSON.parse(error.responseText).error,
                                        });
                                    }
                                });
                            }
                        });
                    };

                    reader.readAsDataURL(file);
                }
            });
        } else {
            // Add additional data
            $.ajax({
                url: "{{url('warehouse-admin/orders/'.$shipping->id)}}", // Replace with your endpoint URL
                type: 'PATCH', // Change this to 'PATCH'
                data: {
                    _method: 'PATCH', // Use _method to emulate PATCH method
                    status: statusShipping,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.notif) {
                        Toast.fire({
                            icon: 'success',
                            title: response.notif.text,
                        });
                        let modal = $('#myModal');
                        modal.modal('hide');
                        if(statusShipping === 'arrived'){
                            window.location.reload();
                        }
                    }
                },
                error: function(error) {
                    
                    Toast.fire({
                        icon: 'error',
                        title: JSON.parse(error.responseText).message ?? JSON.parse(error.responseText).error,
                    });
                }
            });
        }
    }
</script>
