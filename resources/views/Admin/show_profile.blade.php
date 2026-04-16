{{-- <div class="card bg-light d-flex flex-fill"> --}}
    <div class="modal-header border-bottom-0">
        <h5 class="modal-title">{{$type == 'users-menu' ? 'User Profile':'Customer Profile'}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
    <div class="row">
        <div class="col-7">
            <h2 class="lead"><b>{{$user->name}}</b></h2>
            <p class="text-muted"><b>Role: </b> {{$user->role}} </p>
            <ul class="ml-4 mb-0 fa-ul text-muted">
                <li class=""><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Email: {{$user->email}}</li>
                <li class=""><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone : {{$user->phone}}</li>
                <li class=""><span class="fa-li"><i class="fas fa-lg fa-calendar"></i></span> Birth Date : {{Carbon\Carbon::parse($user->birth_date)->format('d-M-Y')}}</li>
            </ul>
        </div>
        <div class="col-5 text-center">
            <img src="{{asset($user->profile_image  ?? 'users_profile_image/man-1.png')}}" alt="user-avatar" class="img-circle img-fluid" style="max-width: 200px;">
        </div>
    </div>
    </div>

    <div class="modal-footer">
        <div class="text-right">
            {{-- @if (is_null($user->email_verified_at))
            <a class="btn btn-sm btn-info verifyEmail" href="{{url('admin/users/'.$user->id.'/verify-email')}}"><i class="fas fa-paper-plane"></i> Verify Email</a>    
            @endif --}}
            @if ($type == 'users-menu')
            <button class="btn btn-sm btn-success changePassword" data-toggle="modal" data-change-password="{{url('admin/users/'.$user->id.'/change-password')}}"><i class="fas fa-key"></i> Change Password</button>
            <button class="btn btn-sm btn-primary updateProfile" data-toggle="modal" data-update-profile="{{url('admin/users/'.$user->id.'/edit')}}"><i class="fas fa-user"></i> Edit Profile</button>
            @else
            <a href="https://wa.me/{{$wa}}" class="btn btn-sm btn-success" target="_blank"><i class="fab fa-whatsapp mr-2"></i> Send Message </a>
            @endif
        </div>
    </div>
{{-- </div> --}}