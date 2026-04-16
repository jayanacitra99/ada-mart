<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invoice Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          <img src="{{asset('adamart-logo.png')}}" class="img-size-32" alt="AdaMart_logo"> AdaMart
          <small class="float-right">Date : {{Carbon\Carbon::parse($order->created_at)->format('d/m/Y')}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>PT. Mentari Berkah Makmur</strong><br>
          Gedung Wirausaha Lantai 1 Unit 104<br>
          Jl. HR Rasuna Said Kav KAret<br>
          Setiabudi, Jakarta Selatan<br>
          Phone: (62) 813-1588-8123<br>
          Email: adamart@gmail.com
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          @php
              $address = $order->shipping->address;
          @endphp
          <strong>{{$address->recipient_name}}</strong><br>
          {{$address->full_address}} {{$address->additional_instructions ? '('.$address->additional_instructions.')':''}}<br>
          {{$address->city}} {{$address->postal_code}}<br>
          Phone: {{$address->recipient_phone_number}}<br>
          Email: {{$address->user?->email ?? '-'}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Order ID:</b> {{$order->id}}<br>
        <br>
        <b>Shipping Number:</b> {{$order->shipping->shipping_number}} <br>
        <br>
        <b>Shipping Type:</b> {{$order->shipping->shipping_type}} <br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Product</th>
              <th>Type</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @php
                $allProductSubtotal = 0;
            @endphp
            @foreach ($order->orderDetails as $orderDetail)
            @php
                $allProductSubtotal += $orderDetail->subtotal;
            @endphp
                <tr>
                  <td>{{$orderDetail->productDetail->product->name}}</td>
                  <td>{{$orderDetail->productDetail->unit_type}}</td>
                  <td>{{'Rp '.number_format($orderDetail->product_price,0,',','.')}}</td>
                  <td>{{$orderDetail->quantity}}</td>
                  <td>{{'Rp '.number_format($orderDetail->subtotal,0,',','.')}}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <p class="lead">Payment Methods:</p>
        <img src="{{asset('bca.png')}}" alt="BCA">

        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
          6825676728 a/n PT. MENTARI BERKAH MAKMUR
        </p>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <div class="row">
          <div class="col-6"><p class="lead">Billed At {{Carbon\Carbon::parse($order->billed_at)->format('d/m/Y')}}</p></div>
          @if ($order->paid_at)
          <div class="col-6"><p class="lead">Paid At {{Carbon\Carbon::parse($order->paid_at)->format('d/m/Y')}}</p></div>
          @endif
        </div>
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>Rp {{number_format($allProductSubtotal,0,',','.')}}</td>
            </tr>
            <tr>
              <th>Promo:</th>
              <td>- Rp {{number_format($order->total_final,0,',','.')}}</td>
            </tr>
            <tr>
              <th>Shipping:</th>
              <td>Rp {{number_format($order->shipping->subtotal,0,',','.')}}</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td>Rp {{number_format($order->total,0,',','.')}}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
