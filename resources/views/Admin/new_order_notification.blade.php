@php
    $newOrders = App\Models\AllNotification::where('name','new_order')->orderBy('id','desc')->get();
@endphp
<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-money-bill-alt"></i>
    <span class="badge badge-warning navbar-badge">{{ $newOrders->count() }}</span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <span class="dropdown-item dropdown-header">{{ $newOrders->count() }} New Orders</span>
    <div class="dropdown-divider"></div>
    @foreach($newOrders as $newOrder)
        <div class="d-flex">
        <a href="{{url('admin/orders')}}" class="dropdown-item" style="white-space: normal;">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ $newOrder->message }}
        </a>
        <a href="#" onclick="markAsRead({{ $newOrder->id }},'new_order')" class="p-1 text-danger"><i class="fas fa-times"></i></a>
        </div>
    <div class="dropdown-divider"></div>
    @endforeach
</div>