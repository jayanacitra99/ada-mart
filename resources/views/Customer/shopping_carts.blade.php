@extends('Customer.layout')
@section('title')
    Shopping Carts
@endsection
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <style>
        .btn-plus-minus {
            background-color: #c00000;
            color: white;
            font-weight: bold;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid pt-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-12 p-0">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped w-100" id="carts-table">
                        <thead class="text-center">
                            <th>
                                <input type="checkbox" class="check-all-carts" {{$carts->count() > 0 ? '':'disabled'}} />
                            </th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                <tr data-cart-id="{{$cart->id}}" data-product-detail-id="{{$cart->product_detail_id}}" class="" disabled="disabled">
                                    <td class="col-lg-1">
                                        <input type="checkbox" class="check-cart"/>
                                    </td>
                                    <td class="col-lg-3">
                                        <div class="d-flex align-items-center">
                                            <img src="{{asset($cart->productDetail->first_image)}}" class="img-size-64 m-2" alt="">
                                            <span>{{$cart->productDetail->product->name}}</span>
                                        </div>
                                    </td>
                                    <td class="col-lg-3">
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown">
                                                <button class="btn border dropdown-toggle unit-type-btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{$cart->productDetail->unit_type}}
                                                </button>
                                                <div class="dropdown-menu unit-type-menu">
                                                    @foreach ($cart->productDetail->product->productDetails as $unit)
                                                        <button class="dropdown-item" data-unit-type="{{$unit->unit_type}}" 
                                                            data-unit-id="{{$unit->id}}" 
                                                            data-quantity-left="{{$unit->quantity}}" 
                                                            data-min-order="{{$unit->min_order}}" 
                                                            data-price="{{$unit->promo?->active ? $unit->promo_price : $unit->price}}">{{$unit->unit_type}}</button>      
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price col-lg-1">
                                        @if ($cart->productDetail->promo?->active)
                                            <small class="text-muted"><s>Rp {{number_format($cart->productDetail->price,0,',','.')}}</s></small> {{'Rp '.number_format($cart->productDetail->promo_price,0,',','.')}}   
                                        @else
                                            {{'Rp '.number_format($cart->productDetail->price,0,',','.')}}
                                        @endif
                                    </td>
                                    <td class="text-center col-lg-2">
                                        <div class="input-group input-group-sm col-10">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-plus-minus btn-sm btn-number btn-min-quantity" 
                                                data-type="minus" 
                                                data-field="quantity" {{$cart->quantity == 1 ? 'disabled' : ''}}>
                                                    <span class="fas fa-minus"></span>
                                                </button>
                                            </span>
                                            <input type="number" name="quantity" class="form-control text-center quantity-input" value="{{$cart->quantity}}" min="{{$cart->productDetail->min_order}}" max="{{$cart->productDetail->quantity}}">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-plus-minus btn-sm btn-number btn-add-quantity" 
                                                data-type="plus" 
                                                data-field="quantity" {{$cart->quantity == $cart->productDetail->quantity ? 'disabled' : ''}}>
                                                    <span class="fas fa-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                        {{-- <span class="text-muted col-2 quantity-left">{{$cart->productDetail->quantity}} Left</span> --}}
                                    </td>
                                    <td class="total-price col-lg-1">
                                        {{'Rp '.number_format(($cart->quantity * ($cart->productDetail->promo_price ?? $cart->productDetail->price)),0,',','.')}}
                                    </td>
                                    <td class="col-lg-1">
                                        <button class="btn btn-sm btn-danger delete-cart"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center fixed-bottom">
        <div class="col-lg-8 col-sm-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 col-lg-9 d-flex align-items-baseline justify-content-center">
                            <h5 class="">Total <span id="selected-product">(0 Product)</span>: </h5><h1 id="total-price" style="color: #c00000">Rp 0</h1>
                        </div>
                        <div class="col-12 col-lg-3 align-content-center">
                            <button class="btn btn-block btn-flat elevation-2 text-white " style="background-color: #c00000" id="order-button"><h4 class="text-bold font-weight-light">Checkout</h4></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->

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
        /* Initialize DataTable */
        $('#carts-table').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });

        /* Check All Checkboxes */
        $('.check-all-carts').on('change', function() {
            $('.check-cart').prop('checked', $(this).is(':checked'));
            updateTotalPrice();
        });

        function parseCurrency(numStr) {
            return parseFloat(numStr.replace(/[^0-9,-]+/g, '').replace(',', '.'));
        }

        function formatCurrency(num) {
            return num.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        /* Update Total Price */
        function updateTotalPrice() {
            let total = 0;
            let selectedProducts = $('.check-cart:checked').length; // Count the checked checkboxes
            $('#selected-product').text(`(${selectedProducts} Product${selectedProducts > 1 ? 's' : ''})`);
            $('.check-cart:checked').each(function() {
                let row = $(this).closest('tr');
                let price = parseCurrency(row.find('.total-price').text());
                total += price;
            });
            $('#total-price').text('Rp ' + formatCurrency(total));
        }
        updateTotalPrice();

        /* Quantity Change */
        $('.btn-number').on('click', function() {
            let row = $(this).closest('tr');
            let cartId = row.data('cart-id');
            let input = row.find('.quantity-input');
            let currentVal = parseInt(input.val());
            let type = $(this).data('type');
            let newVal = type === 'plus' ? currentVal + 1 : currentVal - 1;
            let maxVal = parseInt(input.attr('max'));
            let minVal = parseInt(input.attr('min'));

            if (newVal < 1 || newVal > maxVal) return;

            $.ajax({
                url: "{{url('/cart')}}/"+cartId,
                method: 'PATCH',
                data: { quantity: newVal, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    input.val(newVal);
                    row.find('.total-price').text('Rp ' + formatCurrency(newVal * response.price));
                    row.find('.btn-min-quantity').prop('disabled', newVal == minVal);
                    row.find('.btn-add-quantity').prop('disabled', newVal == maxVal);
                    updateTotalPrice();
                }
            });
        });

        /* Unit Type Change */
        $('.unit-type-menu .dropdown-item').on('click', function() {
            let row = $(this).closest('tr');
            let cartId = row.data('cart-id');
            let unitType = $(this).data('unit-type');
            let unitId = $(this).data('unit-id');
            let quantityLeft = $(this).data('quantity-left');
            let minOrder = $(this).data('min-order');
            let price = $(this).data('price');

            $.ajax({
                url: "{{url('/cart')}}/"+cartId,
                method: 'PATCH',
                data: { productDetailId: unitId, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    row.find('.unit-type-btn').text(unitType);
                    row.find('.price').html(response.priceHtml);
                    row.find('.quantity-left').text(quantityLeft + ' Left');
                    row.find('.quantity-input').attr('max', quantityLeft);
                    row.find('.quantity-input').attr('min', minOrder);
                    let currentVal = parseInt(row.find('.quantity-input').val());
                    if (currentVal > quantityLeft) {
                        currentVal = quantityLeft;
                        row.find('.quantity-input').val(currentVal);
                    }
                    row.find('.total-price').text('Rp ' + formatCurrency(currentVal * price));
                    row.find('.btn-add-quantity').prop('disabled', currentVal == quantityLeft);
                    row.find('.btn-min-quantity').prop('disabled', currentVal == minOrder);
                    updateTotalPrice();
                }
            });
        });

        /* Delete Cart */
        $('.delete-cart').on('click', function() {
            let row = $(this).closest('tr');
            let cartId = row.data('cart-id');

            $.ajax({
                url: "{{url('/cart')}}/"+cartId,
                method: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function(response) {
                    row.remove();
                    updateTotalPrice();
                }
            });
        });

        /* Update Total Price on Checkbox Change */
        $('.check-cart').on('change', function() {
            updateTotalPrice();
        });

        /* Order Button Click */
        $('#order-button').on('click', function() {
            let selectedCarts = $('.check-cart:checked').closest('tr').map(function() {
                return $(this).data('cart-id');
            }).get();
            if (selectedCarts.length > 0) {
                let dataToEncrypt = JSON.stringify({ type: 'carts', carts: selectedCarts });
                $.ajax({
                    url: "{{ url('/encrypt-data') }}",
                    method: 'POST',
                    data: {
                        data: dataToEncrypt,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href = "{{ url('/check-order') }}?data=" + response.encryptedData;
                    }
                });
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'Please pick the product first',
                });
            }
        });
    });
</script>
@endsection
