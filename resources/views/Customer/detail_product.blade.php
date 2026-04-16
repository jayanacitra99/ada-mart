@extends('Customer.layout')
@section('title')
    {{$product->name}}
@endsection
@section('styles')
    <style>
        .btn-unit {
            border: 2px solid #c00000;
            color: #c00000;
            transition: background-color 0.3s, color 0.3s;
        }
        .btn-unit.active {
            background-color: #c00000;
            color: white;
            font-weight: bold;
        }
        .btn-unit:hover {
            background-color: #ffcb39;
            color: black;
            font-weight: bold;
        }
        .btn-add-to-cart,
        .btn-order-now {
            border: 2px solid #c00000;
            color: #c00000;
            transition: background-color 0.3s, color 0.3s;
        }
        .btn-add-to-cart.active,
        .btn-order-now.active {
            background-color: #c00000;
            color: white;
            font-weight: bold;
        }
        .btn-add-to-cart:hover,
        .btn-order-now:hover {
            background-color: #ffcb39;
            color: black;
            font-weight: bold;
        }

        .btn-plus-minus {
            background-color: #c00000;
            color: white;
            font-weight: bold;
        }
        .product-image {
            max-height: 400px;
            object-fit: contain;
        }
        .product-image-thumb img{
            max-height: 100px;
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
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid d-flex justify-content-center pt-lg-5">
            <div class="card card-solid col-11">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <h3 class="d-inline-block d-sm-none">{{$product->name}}</h3>
                      <div class="col-12">
                        @if(json_decode($product->image, true))
                            @foreach(json_decode($product->image, true) as $image)
                                @if ($loop->first)
                                    <img src="{{asset($image)}}" class="product-image" alt="{{basename($image)}}">
                                @endif
                            @endforeach
                        @else
                            No Image Available
                        @endif
                      </div>
                      <div class="col-12 product-image-thumbs">
                        @if(json_decode($product->image, true))
                            @foreach(json_decode($product->image, true) as $image)
                                <div class="product-image-thumb {{$loop->first ? 'active':''}}"><img src="{{asset($image)}}" alt="{{basename($image)}}"></div>
                            @endforeach
                        @else
                            No Image Available
                        @endif
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <h3 class="mt-3">{{$product->name}}</h3>
                      {{-- <p class="d-flex justify-content-end mr-5">{{$product->total_sold}} Sold</p> --}}
                      {{-- <p>{{$product->description}}</p> --}}
        
                      <hr>
                      <h4>Pilih Satuan Belanja</h4>
                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach ($product->productDetails as $productDetail)
                        <label class="btn btn-unit btn-flat text-center {{$loop->first ? 'active':''}}">
                            <input type="radio" name="unit_type" value="{{$productDetail->id}}" id="unit_type_{{$productDetail->id}}" 
                            data-promo-price="{{$productDetail->promo_price}}" 
                            data-show-promo-price="{{number_format($productDetail->promo_price,0,',','.')}}" 
                            data-on-promo="{{$productDetail->promo?->active}}"
                            data-promo-tag="{{$productDetail->promo?->tag}}"
                            data-min-order="{{$productDetail->min_order}}"
                            data-price="{{$productDetail->price}}" 
                            data-show-price="{{number_format($productDetail->price,0,',','.')}}" 
                            data-quantity="{{$productDetail->quantity}}"
                            @auth
                            data-quantity-and-cart="{{$productDetail->quantity - ($productDetail->shoppingCarts()->where('user_id', auth()->user()->id)->value('quantity') ?? 0)}}"
                            @endauth
                            autocomplete="off">
                            {{Str::upper($productDetail->unit_type)}}
                        </label>
                        @endforeach
                      </div>
        
                      <div class="py-2 px-3 mt-4 text-black" style="color: #c00000">
                        <h2 class="mb-0 text-bold">
                            <s class="text-sm p-1 text-muted" style="display: none">Rp <span id="product-price"></span></s>
                            <span id="product-final-price">{{$product->price_range}}</span>
                            <sup class="text-sm px-1 text-white" style="background-color: #c00000; display: none" id="promo-tag"></sup>
                        </h2>
                        <h4 class="mt-0">
                          <small>Total : <span id="total-price">-</span> </small>
                        </h4>
                      </div>
                      <div class="mt-4 row" >
                        <div class="input-group col-5 ">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-plus-minus btn-number" id="btn-min-quantity" disabled="disabled" data-type="minus" data-field="quantity">
                                    <span class="fas fa-minus"></span>
                                </button>
                            </span>
                            <input type="number" name="quantity" id="quantity" onwheel="this.blur()" class="form-control text-center" value="0" min="0" max="10">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-plus-minus btn-number" id="btn-add-quantity" data-type="plus" data-field="quantity">
                                    <span class="fas fa-plus"></span>
                                </button>
                            </span>
                        </div>
                        {{-- <span class="text-muted col-2" id="quantity-left"></span> --}}
                      </div>
                      <div class="mt-4">
                        <a class="btn btn-order-now btn-lg btn-flat" id="btn-buy-now">
                            <i class="fas fa-money-bill-wave fa-lg mr-2"></i>
                            Beli Sekarang
                        </a>
                        <a class="btn btn-add-to-cart btn-lg btn-flat" id="btn-add-to-cart">
                          <i class="fas fa-cart-plus fa-lg mr-2"></i>
                            Keranjang
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-4">
                    <nav class="w-100">
                      <div class="nav nav-tabs" id="product-tab" role="tablist">
                        <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                        {{-- <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Comments</a>
                        <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Rating</a> --}}
                      </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                      <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"> {{$product->description}} </div>
                      <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab"></div>
                      <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab"></div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
      </section>
      <!-- /.content -->
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#quantity').val(0).change();
        let used_price = 0;
        let quantity = 0;
        let total_price = 0;
        function currencyConverter(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        $('.product-image-thumb').on('click', function () {
            var $image_element = $(this).find('img');
            $('.product-image').prop('src', $image_element.attr('src'));
            $('.product-image-thumb.active').removeClass('active');
            $(this).addClass('active');
        });
        $('.btn-group-toggle input[type="radio"]').change(function() {
            $(this).parent().addClass('active').siblings().removeClass('active');
            let logged_in = '{{auth()->check()}}';
            let data_quantity = $(this).data('quantity');
            let min_order = $(this).data('min-order');
            if (logged_in) {
                data_quantity = $(this).data('quantity-and-cart');   
            }
            let data_quantity_left = $(this).data('quantity');
            let onPromo = $(this).data('on-promo');
            if (onPromo) {
                $('#product-price').html($(this).data('show-price'));
                $('#product-price').parent().show();
                $('#product-final-price').html('Rp '+$(this).data('show-promo-price'));
                used_price = $(this).data('promo-price');
                $('#promo-tag').show();
                $('#promo-tag').html($(this).data('promo-tag'));
                 
            } else {
                $('#promo-tag').hide();
                $('#product-price').parent().hide();
                $('#product-final-price').html('Rp '+$(this).data('show-price'));
                used_price = $(this).data('price');   
            }
            $('#quantity').attr('max',data_quantity).change();
            $('#quantity').attr('min',min_order).change();
            $('#quantity').val(min_order).change();
            quantity = 0;
            // $('#quantity-left').html(data_quantity_left+' left');
            total_price = quantity * used_price;
            $('#total-price').html('Rp '+currencyConverter(total_price));
        });
        $('.btn-number').click(function(e){
            e.preventDefault();
            fieldName = $(this).attr('data-field');
            type      = $(this).attr('data-type');
            var input = $("input[name='"+fieldName+"']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    
                    if(currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                        quantity = input.val();
                        total_price = quantity * used_price;
                        $('#total-price').html('Rp '+currencyConverter(total_price));
                        $('#btn-add-quantity').attr('disabled', false);
                    } 
                    if(parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if(type == 'plus') {

                    if(currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                        quantity = input.val();
                        total_price = quantity * used_price;
                        $('#total-price').html('Rp '+currencyConverter(total_price));
                        $('#btn-min-quantity').attr('disabled', false);
                    }
                    if(parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0).change();
            }
        });

        $('#btn-add-to-cart').click(function(e) {
            e.preventDefault();
            let unitType    = $('input[name="unit_type"]:checked').val();
            let quantity    = $('#quantity').val();
            let userId      = {{ auth()->check() ? auth()->user()->id : 'null' }};
            
            if(unitType && quantity > 0) {
                $.ajax({
                    url: '{{ route("cart.add") }}',
                    method: 'POST',
                    data: {
                        unit_type   : unitType,
                        quantity    : quantity,
                        user_id     : userId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            let badge = $('#shopping-cart-badge');
                            badge.text(response.count_cart);
                            Toast.fire({
                                icon: 'success',
                                title: response.message,
                            });
                        } else {
                            Toast.fire({
                                icon: 'warning',
                                title: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 401) { // Unauthorized
                            Swal.fire({
                                title: '{{auth()->check() ? "You Still Login as Admin":"Unauthenticated"}}',
                                text: '{{auth()->check() ? "Please Logout First then use Customer Account":"Please Login First"}}',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '{{auth()->check() ? "#c00000":"#3085d6"}}',
                                confirmButtonText: '{{auth()->check() ? "Logout Now":"Login Now"}}',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if ('{{auth()->check()}}') {
                                    $.ajax({
                                        url: '{{ url('logout') }}', // The URL to send the request to
                                        method: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}' // Include the CSRF token
                                        },
                                        success: function(response){
                                            // Handle success (e.g., redirect to the login page, show a success message, etc.)
                                            window.location.href = '{{ route("login") }}';
                                        },
                                        error: function(xhr){
                                            // Handle error (e.g., show an error message)
                                            alert('An error occurred while logging out. Please try again.');
                                        }
                                    });
                                    } else {
                                    window.location.href = '{{ route("login") }}';
                                    } 
                                }
                            })
                        } else {
                            Toast.fire({
                                icon: 'warning',
                                title: 'An error occurred. Please try again.',
                            });
                        }
                    }
                });
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'Please select a unit type and quantity.',
                });
            }
        });
    })
</script>
@endsection
