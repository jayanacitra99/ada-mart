<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Update Profile</h3>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- form start -->
                <form method="post" action="{{url('admin/users/'.$user->id)}}" id="update_profile_form" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                        </div>
                        <div class="form-group col">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" pattern="0[0-9]{8,12}" value="{{$user->phone}}">
                        </div>
                        <div class="form-group col">
                            <label>Birth Date:</label>
                              <div class="input-group date" id="birth_date" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" name="birth_date" data-target="#birth_date"/>
                                  <div class="input-group-append" data-target="#birth_date" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                              </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <img id="imagePreview" src="{{asset($user->profile_image)}}" alt="Image Preview" style="max-width: 200px;">
                    </div>
                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <div class="input-group col-4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" accept="image/*" name="profile_image" id="profile_image" onchange="previewImage(event)">
                                <label class="custom-file-label" for="profile_image" id="imageLabel">Choose file</label>
                            </div>
                        </div>
                    </div>
                    {{-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> --}}
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
<!-- /.col -->
</div>
<!-- /.row -->
<script>
    $(document).ready(function(){
        var birthDateValue = "{{ $user->birth_date}}";
        $('#birth_date').datetimepicker({
            format: 'YYYY-MM-DD',
            defaultDate: birthDateValue
        });
        // Open datepicker when clicking on the input field
        $('#birth_date').on('click', function() {
            $(this).datetimepicker('show');
        });
    })
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);

        // Update the label text with the selected image name
        var fileName = event.target.files[0].name;
        document.getElementById('imageLabel').innerText = fileName;
    }
    function submitForm() {
        let formData = new FormData($('#update_profile_form')[0]);
        // Add additional data
        $.ajax({
            url: "{{url('admin/users/'.$user->id)}}", // Replace with your endpoint URL
            type: 'POST',
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
                    let url = "{{url('admin/users/'.$user->id)}}";
                    modal.find('.modal-content').empty();
                    modal.find('.modal-content').load(url, function(result){
                        modal.modal('show');
                    });
                    // modal.modal('hide');
                }
            },
            error: function(error) {
                Toast.fire({
                    icon: 'error',
                    title: JSON.parse(error.responseText).message,
                });
            }
        });
    }
</script>