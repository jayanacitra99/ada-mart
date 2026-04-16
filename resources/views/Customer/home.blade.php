@extends('Customer.layout')
@section('title')
    AdaMart - Home
@endsection
@section('styles')
    <style>
        .carousel-list img {
            max-height: 400px;
            max-width: 1500px;
            width: auto;
            margin: auto;
            object-fit: cover;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 2%;
        }

        .btn-buy-now {
            background-color: #058648;
            color: white;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-buy-now:hover {
            background-color: #ffcb39;
            color: #c00000;
        }

        .btn-cart-plus {
            background-color: #ffcb39;
            color: #c00000;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-cart-plus:hover {
            background-color: #c00000;
            color: white;
        }

        .btn-cart-plus:hover i {
            color: white;
        }

        .btn-cart-plus i {
            color: #c00000;
        }
        .title-bg-color {
            background-image: -webkit-linear-gradient(-30deg, #c00000 50%, #ffcb39 50%);
        }
    </style>
    <style>
        .fab-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .fab {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .fab-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background-color: #ffcb39;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .fab-btn:hover {
            background-color: #e0b12e;
        }

        .fab-btn i {
            font-size: 24px;
            color: #c00000;
        }

        .fab-options {
            position: absolute;
            bottom: 70px;
            display: none;
            flex-direction: column;
            align-items: center;
        }

        .fab-options.show {
            display: flex;
        }

        .fab-option {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #ffcb39;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .fab-option:hover {
            background-color: #e0b12e;
        }

        .fab-option i {
            font-size: 20px;
            color: #c00000;
        }
    </style>
@endsection
@section('content')
    <!-- Main content -->
    <div class="container-fluid">
        @if ($carousels->count() > 0)
            <div class="row justify-content-center">
                <div class="col-11">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="carouselIndicators" class="carousel slide" data-ride="carousel" data-interval="5000">
                        <div class="carousel-inner">
                            <ol class="carousel-indicators">
                                @foreach ($carousels as $index => $item)
                                <li data-target="#carouselIndicators" data-slide-to="{{$index}}" class="{{$loop->first ? 'active':''}}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($carousels as $carousel)
                                    <div class="carousel-list carousel-item {{$loop->first ? 'active':''}}">
                                        <a href="{{url('/all-products?promo=true')}}">
                                            <img class="d-block w-100" src="{{asset($carousel->image)}}" alt="{{$carousel->name}}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <a class="carousel-control-prev text-black-50" href="#carouselIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                            <i class="fas fa-chevron-left"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next text-black-50" href="#carouselIndicators" role="button" data-slide="next">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                            <i class="fas fa-chevron-right"></i>
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- /.card -->
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-11">
                <div class="card-header title-bg-color border-0">
                    <div class="row">
                        <div class="d-flex align-items-center justify-content-center col-6">
                            <h4 class="text-white text-bold">Categories</h4>
                        </div>
                    </div>
                </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div id="categoryCarousel" class="carousel slide" data-interval="5000">
                      <div class="carousel-inner">
                        @php $chunked_categories = array_chunk($categories->toArray(), 5); @endphp
                            @foreach ($chunked_categories as $index => $chunk)
                            <div class="carousel-item @if($index === 0) active @endif"> 
                                <div class="row d-flex justify-content-center">
                                    @foreach ($chunk as $category)
                                    <div class="col-sm-12 col-lg-2 col-md-6 mb-1" style="">
                                        <div class="card" style="height: 100%">
                                            <div class="card-header bg-transparent d-flex justify-content-center align-items-center mt-1" style="height: 20%">
                                                <h5 class="text-center"><b>{{$category['name']}}</b></h5>   
                                            </div>
                                            <div class="card-body" class="height:80%">
                                                <a href="{{url('/all-products?category_id='.$category['id'])}}" data-title="{{$category['name']}}" class="">
                                                    <img src="{{asset($category['image'])}}" loading="lazy" alt="{{$category['name']}}" class="w-100 h-100" style="object-fit: contain;"/>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach 
                                </div>                                 
                            </div>
                        @endforeach
                      </div>
                      <a class="carousel-control-prev text-black-50" href="#categoryCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-custom-icon" aria-hidden="true">
                          <i class="fas fa-chevron-left"></i>
                        </span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next text-black-50" href="#categoryCarousel" role="button" data-slide="next">
                        <span class="carousel-control-custom-icon" aria-hidden="true">
                          <i class="fas fa-chevron-right"></i>
                        </span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                  </div>
                  <!-- /.card-body -->
                <!-- /.card -->
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-11 p-0">
                <div class="card-header title-bg-color border-0">
                    <div class="row">
                        <div class="d-flex align-items-center justify-content-center col-6">
                            <h4 class="text-white text-bold">Promo</h4>
                        </div>
                        <div class="d-flex align-items-center justify-content-end col-6">
                            <a href="{{url('/all-products?promo=true')}}" class="btn" style="background-color: #c00000"><h5 class="text-white text-bold m-0">Show More</h5></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($productsPromo as $index => $productPromo)
                            @php
                                $images = json_decode($productPromo->image, true);
                                $firstImage = 'products/no-image.png'; // Default image if no valid image found

                                if (is_array($images)) {
                                    foreach ($images as $image) {
                                        if (!is_null($image) && $image !== '') {
                                            $firstImage = $image;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            @php
                                $onPromo = $productPromo->productDetails()->whereHas('promo',function($q){$q->byActive();})->first();
                            @endphp
                            <div class="col-lg-3 col-md-6 col-12" style="max-height: 600px">
                                <div class="card" style="height: 95%">
                                    <div class="card-body" style="height: 85%;">                              
                                        @if ($onPromo)
                                            <div class="ribbon-wrapper ribbon-lg product-ribbon">
                                                <div class="ribbon" style="background-color: #c00000">
                                                    <span class="text-white"><b>{{ $onPromo->promo->tag }}</b></span>
                                                </div>
                                            </div>
                                        @endif
                                        <a href="{{url('/detail-products/'.$productPromo->id)}}" class="" style="">
                                            <div style="height: 85%;">
                                                <img src="{{ asset($firstImage) }}" loading="lazy" alt="{{ $productPromo->name }}" class="w-100 h-100" style="object-fit: contain; max-height: 80%"/>
                                                <p class="mb-0 h-auto" style=""><b>{{ $productPromo->name }}</b></p>
                                            </div>
                                        </a>
                                        <div class="h-auto" style="">
                                                @if ($onPromo->promo_price)
                                                    <p class="d-flex justify-content-start mb-0 text-truncate"><s class="text-secondary mr-1">{{ 'Rp ' . number_format($onPromo->price, 0, ',', '.') }}</s>{{ 'Rp ' . number_format($onPromo->promo_price, 0, ',', '.') }} / 1 {{ $onPromo->unit_type }}</p>
                                                @else
                                                    <p class="d-flex justify-content-start mb-0 text-truncate">{{ 'Rp ' . number_format($onPromo->price, 0, ',', '.') }} / 1 {{ $onPromo->unit_type }}</p>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent mt-1" style="height: 15%;">
                                        <div class="d-flex justify-content-between">
                                            <a href="#" class="btn btn-lg btn-buy-now col-8 p-2 text-truncate" data-product-details="{{ json_encode($productPromo->productDetails->load('shoppingCarts')->toArray()) }}" data-action="order"><i class="fas fa-money-bill-wave mr-2"></i>Beli</a>
                                            <a href="#" class="btn btn-lg btn-cart-plus col-3 p-2" data-product-details="{{ json_encode($productPromo->productDetails->load('shoppingCarts')->toArray()) }}" data-action="cart"><i class="fas fa-cart-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>  
        <div class="row justify-content-center">
            <div class="col-11 p-0">
                <div class="card-header title-bg-color border-0">
                    <div class="row">
                        <div class="d-flex align-items-center justify-content-center col-6">
                            <h4 class="text-white text-bold">Products</h4>
                        </div>
                        <div class="d-flex align-items-center justify-content-end col-6">
                            <a href="{{url('/all-products')}}" class="btn" style="background-color: #c00000"><h5 class="text-white text-bold m-0">Show More</h5></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($products as $index => $product)
                            @php
                                $images = json_decode($product->image, true);
                                $firstImage = 'products/no-image.png'; // Default image if no valid image found

                                if (is_array($images)) {
                                    foreach ($images as $image) {
                                        if (!is_null($image) && $image !== '') {
                                            $firstImage = $image;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            @php
                                $onPromo = $product->productDetails()->whereHas('promo',function($q){$q->byActive();})->first();
                                $firstProduct = $product->productDetails()->orderByDesc('id')->first();
                            @endphp
                            <div class="col-lg-3 col-md-6 col-12" style="max-height: 600px">
                                <div class="card" style="height: 95%">
                                    <div class="card-body" style="height: 85%;">                              
                                        @if ($onPromo)
                                            <div class="ribbon-wrapper ribbon-lg product-ribbon">
                                                <div class="ribbon" style="background-color: #c00000">
                                                    <span class="text-white"><b>{{ $onPromo->promo->tag }}</b></span>
                                                </div>
                                            </div>
                                        @endif
                                        <a href="{{url('/detail-products/'.$product->id)}}" class="" style="">
                                            <div style="height: 85%;">
                                                <img src="{{ asset($firstImage) }}" loading="lazy" alt="{{ $product->name }}" class="w-100 h-100" style="object-fit: contain; max-height: 80%"/>
                                                <p class="mb-0 h-auto" style=""><b>{{ $product->name }}</b></p>
                                            </div>
                                        </a>
                                        <div class="h-auto" style="">
                                                @if ($firstProduct->promo_price)
                                                    <p class="d-flex justify-content-start mb-0 text-truncate"><s class="text-secondary mr-1">{{ 'Rp ' . number_format($firstProduct->price, 0, ',', '.') }}</s>{{ 'Rp ' . number_format($firstProduct->promo_price, 0, ',', '.') }} / 1 {{ $firstProduct->unit_type }}</p>
                                                @else
                                                    <p class="d-flex justify-content-start mb-0 text-truncate">{{ 'Rp ' . number_format($firstProduct->price, 0, ',', '.') }} / 1 {{ $firstProduct->unit_type }}</p>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent mt-1" style="height: 15%;">
                                        <div class="d-flex justify-content-between">
                                            <a href="#" class="btn btn-lg btn-buy-now col-8 p-2 text-truncate" data-product-details="{{ json_encode($product->productDetails->load('shoppingCarts')->toArray()) }}" data-action="order"><i class="fas fa-money-bill-wave mr-2"></i>Beli</a>
                                            <a href="#" class="btn btn-lg btn-cart-plus col-3 p-2" data-product-details="{{ json_encode($product->productDetails->load('shoppingCarts')->toArray()) }}" data-action="cart"><i class="fas fa-cart-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fab-container">
        <div class="fab">
            <div class="fab-btn">
                <i class="fas fa-headset"></i>
            </div>
            <div class="fab-options">
                @php
                    $admin = App\Models\User::find(1);
                    $wa_admin = 'wa.me/62' . ltrim($admin->phone, '0');
                @endphp
                <a href="https://{{$wa_admin}}?text=Halo%20Admin" target="_blank">
                    <div class="fab-option">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                </a>
                <a href="https://instagram.com/AdaMart" target="_blank">
                    <div class="fab-option">
                        <i class="fab fa-instagram"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.fab-btn').on('click', function() {
            $('.fab-options').toggleClass('show');
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.fab').length) {
                $('.fab-options').removeClass('show');
            }
        });
    });
</script>
@endsection
