<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Change Password</h3>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- form start -->
                <form method="post" action="{{url('admin/users/'.$user->id.'/update-password')}}" id="change_password_form">
                    @csrf
                    <div class="row">
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
                    </div>
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
    function submitForm() {
        let formData = $('#change_password_form').serializeArray();
        // Add additional data
        $.ajax({
            url: "{{url('admin/users/'.$user->id.'/update-password')}}", // Replace with your endpoint URL
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.notif) {
                    Toast.fire({
                        icon: 'success',
                        title: response.notif.text,
                    });
                    let modal = $('#myModal');
                    modal.modal('hide');
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