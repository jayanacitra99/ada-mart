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
        $firstProduct = $product->productDetails()->first();
    @endphp
    <div class="col-lg-3 col-md-6 col-12" style="max-height: 600px">
        <div class="card" style="height: 95%;">
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
                        <img src="{{ asset($firstImage) }}" loading="lazy" alt="{{ $product->name }}" class="w-100 h-100" style="object-fit: contain; height: 80%"/>
                        <p class="mb-0 h-auto" style=""><b>{{ $product->name }}</b></p>
                    </div>
                </a>
                <div class="h-auto" style="">
                    @if ($firstProduct->promo_price)
                        <p class="d-flex justify-content-start {{!$loop->last ? 'mb-0':''}} text-truncate"><s class="text-secondary mr-1">{{ 'Rp ' . number_format($firstProduct->price, 0, ',', '.') }}</s>{{ 'Rp ' . number_format($firstProduct->promo_price, 0, ',', '.') }} / 1 {{ $firstProduct->unit_type }}</p>
                    @else
                        <p class="d-flex justify-content-start {{!$loop->last ? 'mb-0':''}} text-truncate">{{ 'Rp ' . number_format($firstProduct->price, 0, ',', '.') }} / 1 {{ $firstProduct->unit_type }}</p>
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
