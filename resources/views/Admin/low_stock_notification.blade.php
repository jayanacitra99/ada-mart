@php
    $lowStocks = App\Models\AllNotification::where('name','low_stock')->get();
@endphp
<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-bell"></i>
    <span class="badge badge-warning navbar-badge">{{ $lowStocks->count() }}</span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <span class="dropdown-item dropdown-header">{{ $lowStocks->count() }} lowStocks</span>
    <div class="dropdown-divider"></div>
    @foreach($lowStocks as $lowStock)
        <div class="d-flex">
        <a href="{{url('admin/products/'.$lowStock->related_id.'/edit')}}" class="dropdown-item" style="white-space: normal;">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ $lowStock->message }}
        </a>
        <a href="#" onclick="markAsRead({{ $lowStock->id }}, 'low_stock')" class="p-1 text-danger"><i class="fas fa-times"></i></a>
        </div>
    <div class="dropdown-divider"></div>
    @endforeach
</div>