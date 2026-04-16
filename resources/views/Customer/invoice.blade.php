@extends('Customer.layout')
@section('title')
    Invoice
@endsection
@section('styles')
@endsection
@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-8">
      <!-- Main content -->
      <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h4>
              <img src="{{asset('adamart-logo.png')}}" class="img-size-32" alt="AdaMart_logo"> KaromahJaya
              <small class="float-right">Date : {{Carbon\Carbon::parse($order->created_at)->format('d/m/Y')}}</small>
            </h4>
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
              <strong>{{$address?->recipient_name}}</strong><br>
              {{$address?->full_address}} {{$address?->additional_instructions ? '('.$address?->additional_instructions.')':''}}<br>
              {{$address?->city}} {{$address?->postal_code}}<br>
              Phone: {{$address?->recipient_phone_number}}<br>
              Email: {{$address?->user?->email ?? '-'}}
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
              <p>
                <strong>Note:</strong> Jika pembelian ini membutuhkan faktur pajak silahkan hubungi Customer Service kami paling lambat 20 hari setelah transaksi.
              </p>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-12">
            <a href="{{url('invoice-print/'.$order->id)}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            @if (is_null($order->paid_at))
            <button type="button" class="btn btn-success float-right" id="btn-submit-payment"><i class="far fa-credit-card"></i> Submit
              Payment
            </button>
            @endif
          </div>
        </div>
      </div>
      <!-- /.invoice -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection
@section('scripts')
<script>
  $(document).ready(function(){
    $('#btn-submit-payment').on('click', function() {
          Swal.fire({
              title: 'Submit Payment',
              html: `
                  <form id="paymentForm" enctype="multipart/form-data">
                      <input type="file" id="payment_receipt" name="payment_receipt" accept="image/*" class="form-control mb-3">
                      <img id="receiptPreview" src="" alt="Receipt Preview" class="img-fluid" style="display:none;">
                  </form>
              `,
              showCancelButton: true,
              confirmButtonText: 'Submit',
              cancelButtonText: 'Cancel',
              preConfirm: () => {
                  const fileInput = document.getElementById('payment_receipt');
                  if (!fileInput.files.length) {
                      Swal.showValidationMessage('Please select a file to upload');
                      return false;
                  }
                  return new Promise((resolve) => {
                      const formData = new FormData();
                      formData.append('payment_receipt', fileInput.files[0]);
                      formData.append('_token', '{{ csrf_token() }}');

                      $.ajax({
                          url: '{{ url("submit-payment/".$order->id) }}',
                          method: 'POST',
                          data: formData,
                          processData: false,
                          contentType: false,
                          success: function(response) {
                              resolve(response);
                          },
                          error: function(xhr) {
                              Swal.showValidationMessage('An error occurred: ' + xhr.responseText);
                          }
                      });
                  });
              }
          }).then((result) => {
              if (result.isConfirmed && result.value) {
                  Swal.fire({
                      title: 'Payment Submitted',
                      text: 'Your payment receipt has been received and will be verified. Please wait.',
                      icon: 'success'
                  });
                  window.location.href = "{{url('my-account#custom-tabs-one-billed')}}";
              }
          });

          $('#payment_receipt').on('change', function() {
              const [file] = this.files;
              if (file) {
                  $('#receiptPreview').attr('src', URL.createObjectURL(file)).show();
              }
          });
      });
  });
</script>
@endsection
