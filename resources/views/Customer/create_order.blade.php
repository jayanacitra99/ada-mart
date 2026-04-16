    @extends('Customer.layout')
    @section('title')
        Checkout
    @endsection
    @section('styles')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <style>
            #address-line {
                background-image: repeating-linear-gradient(45deg,#6fa6d6,#6fa6d6 33px,transparent 0,transparent 41px,#f18d9b 0,#f18d9b 74px,transparent 0,transparent 82px);
                background-position-x: -30px;
                background-size: 116px 3px;
                height: 3px;
                width: 100%;
            }
        </style>
    @endsection
    @section('content')
        <div class="container-fluid pt-lg-5">
            <div class="col-12 d-flex justify-content-center">
                <div class="card col-8">
                    <div id="address-line"></div>
                    <div class="card-body">
                        <div>
                            <h4 style="color: #c00000" class="font-weight-light"><i class="fa fa-map-marker-alt mr-3"></i>Address</h4>
                        </div>
                        <div class="row">
                            <div class="contact-detail col-4">
                                <h5 class="text-bold">{{$address->recipient_name}}</h5>
                                <h5 class="text-bold">{{$address->recipient_phone_number}}</h5>
                            </div>
                            <div class="full-address col-6">
                                <h5 class="font-weight-light">{{$address->combined_address}}</h5>
                            </div>
                            <div class="change-address col-2 text-right">
                                <button class="btn btn-outline-danger btn-sm" id="changeAddressBtn">Change Address</button>
                            </div>                            
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-around">
                        <div class="form-check col-6 text-center">
                            <input type="radio" name="shipping_type" id="delivery-type" value="delivery" checked>
                            <label class="form-check-label" for="delivery-type">Delivery</label>
                        </div>
                        <div class="form-check col-6 text-center">
                            <input type="radio" name="shipping_type" id="pick-up-type" value="pick-up">
                            <label class="form-check-label" for="pick-up-type">Pick Up</label>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="card col-8">
                    <div class="card-body">
                        <div>
                            <h4 class="font-weight-normal">Products</h4>
                        </div>
                        <div>
                            <table class="table table-striped">
                                <thead>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-right">Subtotal</th>
                                </thead>
                                <tbody>
                                    @if ($type == 'carts')
                                        @php
                                            $subtotal_product = 0
                                        @endphp
                                        @foreach ($carts as $cart)
                                            @php
                                                $subtotal = $cart->quantity * ($cart->productDetail->promo_price ?? $cart->productDetail->price);
                                                $subtotal_product += $subtotal;
                                            @endphp
                                            <tr>
                                                <td class="col-6">
                                                    <div class="row align-items-center">
                                                        <div class="d-flex align-items-center col-8">
                                                            <img src="{{asset($cart->productDetail->first_image)}}" class="img-size-64 m-2" alt="">
                                                            <span>{{$cart->productDetail->product->name}}</span>
                                                        </div>
                                                        <div class="col-4">
                                                            <span class="text-muted">Type : {{$cart->productDetail->unit_type}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="col-3">
                                                    @if ($cart->productDetail->promo?->active)
                                                        <small class="text-muted"><s>Rp {{number_format($cart->productDetail->price,0,',','.')}}</s></small> {{'Rp '.number_format($cart->productDetail->promo_price,0,',','.')}}   
                                                    @else
                                                        {{'Rp '.number_format($cart->productDetail->price,0,',','.')}}
                                                    @endif
                                                </td>
                                                <td class="col-1">
                                                    {{$cart->quantity}}
                                                </td>
                                                <td class="col-2 text-right">
                                                    Rp {{number_format($subtotal,0,',','.')}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @elseif($type == 'direct')
                                        <tr>
                                            <td class="col-6">
                                                <div class="row align-items-center">
                                                    <div class="d-flex align-items-center col-8">
                                                        <img src="{{asset($productDetail->first_image)}}" class="img-size-64 m-2" alt="">
                                                        <span>{{$productDetail->product->name}}</span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="text-muted">Type : {{$productDetail->unit_type}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col-3">
                                                @if ($productDetail->promo?->active)
                                                    <small class="text-muted"><s>Rp {{number_format($productDetail->price,0,',','.')}}</s></small> {{'Rp '.number_format($productDetail->promo_price,0,',','.')}}   
                                                @else
                                                    {{'Rp '.number_format($productDetail->price,0,',','.')}}
                                                @endif
                                            </td>
                                            <td class="col-1">
                                                {{$quantity}}
                                            </td>
                                            <td class="col-2 text-right">
                                                Rp {{number_format($subtotal_product,0,',','.')}}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="card col-8">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <h4 class="font-weight-light"><i class="fa fa-ticket-alt mr-3" style="color: #c00000"></i> Promo Code</h4>
                            </div>
                            <div class="col-4">
                                <input type="text" name="promo_code" id="promo_code" class="form-control" value="" placeholder="Enter Promo Code ...">
                            </div>
                            <div class="col-5">
                                <div class="col-6 text-center font-weight-light" id="promo-tag"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="card col-8">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-end">
                            <div class="d-flex justify-content-between w-50">
                                <h4 class="font-weight-light">Product Subtotal : </h4>
                                <h4 class="font-weight-light" id="product-subtotal">Rp {{number_format($subtotal_product,0,',','.')}}</h4>
                            </div>
                            <div class="d-flex justify-content-between w-50">
                                <h4 class="font-weight-light">Promo Code : </h4>
                                <h4 class="font-weight-light" id="promo-subtotal">Rp </h4>
                            </div>
                            <div class="d-flex justify-content-between w-50">   
                                <h4 class="font-weight-light">Total Payment : </h4>
                                <h4 class="font-weight-light" id="total-payment">Rp </h4>
                            </div>
                            <button id="orderNowBtn" class="btn btn-block w-50 text-bold text-white btn-flat" style="background-color: #c00000">Beli Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
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
        $(document).ready(function() {
            let totalPay = 0;
            let validPromoCode = null;
            let addressId = {{$address->id}};
            let type = '{{$type}}';
            $('#changeAddressBtn').click(function() {
                let modal = $('#myModal');
                let url = "{{url('/addresses-list')}}/"+addressId;
                modal.find('.modal-content').empty();
                modal.find('.modal-content').load(url, function(result){
                    modal.modal('show');
                }); 
            });

            $(document).on('click','#saveAddressChanges',function() {
                var selectedAddressId = $('input[name="address"]:checked').val();
                var selectedAddress = $("label[for='address" + selectedAddressId + "']").text();
                addressId = parseInt(selectedAddressId);
                // Update contact details and full address
                $('.contact-detail h5').eq(0).text(selectedAddress.split(" - ")[0]);
                $('.contact-detail h5').eq(1).text(selectedAddress.split(" - ")[1]);
                $('.full-address h5').text(selectedAddress.split(" - ")[1]);

                // Close modal
                $('#myModal').modal('hide');
            });
            function calculateTotal() {
                const promoCode = $('#promo_code').val();
                const subtotal = {{$subtotal_product}};

                $.ajax({
                    url: "{{url('/calculate-total')}}",
                    type: 'POST',
                    data: JSON.stringify({ 
                        promo_code: promoCode,
                        subtotal: subtotal
                    }),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#promo-subtotal').text(data.promo_subtotal);
                        $('#total-payment').text(data.total_payment);
                        totalPay = data.total_pay;
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            }
            calculateTotal();   
            function checkPromoCode() {
                const promoCode = $('#promo_code').val();
                if(promoCode){
                    $.ajax({
                        url: "{{url('/check-promo-code')}}",
                        type: 'POST',
                        data: JSON.stringify({ promo_code: promoCode }),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            const promoInput = $('#promo_code');
                            const promoTag = $('#promo-tag');

                            if (data.valid) {
                                promoInput.removeClass('is-invalid').addClass('is-valid');
                                promoTag.text(data.tag);
                                validPromoCode = promoCode;
                                calculateTotal();
                            } else {
                                promoInput.removeClass('is-valid').addClass('is-invalid');
                                validPromoCode = null;
                                promoTag.text('');
                            }
                        },
                        error: function(error) {
                            Toast.fire({
                                icon: 'warning',
                                title: 'Error:', error,
                            });
                            console.error('Error:', error);
                        }
                    });
                } else {
                    const promoInput = $('#promo_code');
                    promoInput.removeClass('is-invalid');
                    promoInput.removeClass('is-valid');
                }
            }

            // Trigger promo code check on keyup event
            $('#promo_code').on('keyup', function() {
                checkPromoCode();
            });

            // Trigger promo code check on page load if input is not empty
            if ($('#promo_code').val() !== '') {
                checkPromoCode();
            }else {
                $('#promo_code').val(''); // Clear input if it's empty on page load
            }

            // Beli Sekarang button click handler
            $('#orderNowBtn').click(function() {
                const totalPayment = totalPay;
                let shippingType = $('input[name="shipping_type"]:checked').val();
                let postData
                if (type === 'carts') {
                    @if(isset($carts))
                        const cartIds = @json($carts->pluck('id'));
                    @endif
                    postData = JSON.stringify({
                        type:type,
                        total_payment: totalPayment,
                        cart_ids: cartIds,
                        promo_code: validPromoCode,
                        address_id: addressId,
                        shipping_type: shippingType,
                    });
                } else if(type === 'direct'){
                    @if(isset($productDetail))
                        const productDetailId = {{$productDetail->id}};
                    @endif
                    @if(isset($quantity))
                        const quantity = {{$quantity}};
                    @endif
                    postData = JSON.stringify({
                        type:type,
                        total_payment: totalPayment,
                        productDetailId: productDetailId,
                        quantity: quantity,
                        promo_code: validPromoCode,
                        address_id: addressId,
                        shipping_type: shippingType,
                    });
                }
                $.ajax({
                    url: "{{url('/place-order')}}",
                    type: 'POST',
                    data: postData,
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Handle success response
                        Toast.fire({
                            icon: 'success',
                            title: 'Order placed successfully!'
                        });
                        window.location.href = "{{url('/invoice')}}/"+response.order_id; // Redirect to order confirmation page
                    },
                    error: function(error) {
                        // Handle error response
                        console.error('Error:', error);
                        Toast.fire({
                            icon: 'warning',
                            title: JSON.parse(error.responseText).message,
                            html:JSON.parse(error.responseText).error
                        });
                    }
                });
            });
        });
    </script>   
    @endsection
