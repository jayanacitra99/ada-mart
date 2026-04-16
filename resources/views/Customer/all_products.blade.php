@extends('Customer.layout')
@section('title')
    AdaMart Home
@endsection
@section('styles')
<style>
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

    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #c00000;
        border-bottom: 16px solid #c00000;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .title-bg-color {
        background-image: -webkit-linear-gradient(-30deg, #c00000 50%, #ffcb39 50%);
    }
</style>
<style>
    .back-to-top {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
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

    .back-to-top:hover {
        background-color: #ffcb39;
    }

    .back-to-top i {
        font-size: 24px;
        color: #c00000;
    }
</style>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-11 p-0">
                <div class="card-header title-bg-color">
                    <div class="d-flex justify-content-around">
                        <h1 class="text-white ">{{ $title }}</h1>
                        <div></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" id="product-list">
                        @include('Customer.product_items', ['products' => $products])
                    </div>
                    <div id="loading" class="d-flex justify-content-center mt-5" style="display: none;">
                        <div class="loader" id="loadProductLoader"></div>
                        <p id="end-message" class="text-bold" style="display: none; color :#c00000">That's All the Products We Have For Now</p>
                        <p id="no-match" class="text-bold" style="display: none; color :#c00000">Ooppss!! There is Nothing Here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="back-to-top" id="backToTop">
    <i class="fas fa-arrow-up"></i>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.onscroll = function() {
            var backToTopButton = document.getElementById("backToTop");
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                backToTopButton.style.display = "flex";
            } else {
                backToTopButton.style.display = "none";
            }
        };

        // Scroll smoothly back to the top when the button is clicked
        document.getElementById("backToTop").onclick = function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
        const productCount = {{ count($products) }};
        const allProducts = {{$totalProducts}};
        // Hide the loader if there are products on initial load
        if (productCount > 0) {
            document.getElementById('loadProductLoader').style.display = 'none';
            // If the number of products is less than the minimum required to scroll, show the end message
            if (productCount == allProducts) {
                document.getElementById('end-message').style.display = 'block';
            }
        } else {
            document.getElementById('loadProductLoader').style.display = 'none';
            document.getElementById('no-match').style.display = 'block';
        }

        let skip = {{ count($products) }};
        let loading = false;
        let hasMore = true;
        let isPromo = {{ $isPromo ? 1 : 0 }};
        let categoryId = {{$categoryId ?? 'null'}};
        if (categoryId === 'null') {
            categoryId = null;
        }
        let search = {{$search ?? 'null'}};
        if (search === 'null') {
            search = null;
        }

        window.onscroll = function() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500 && !loading && hasMore) {
                if (productCount < allProducts) {
                    loadMoreProducts();
                }
            }
        };

        function loadMoreProducts() {
            loading = true;
            document.getElementById('loadProductLoader').style.display = 'block';
            let url = `{{ route('load-more-products') }}?skip=${skip}&promo=${isPromo}`;
            if (categoryId !== null) {
                url += `&category_id=${categoryId}`;
            }
            if (search !== null) {
                url += `&search=${search}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const productContainer = document.getElementById('product-list');
                    productContainer.insertAdjacentHTML('beforeend', data.html);
                    skip += 15;
                    loading = false;
                    document.getElementById('loadProductLoader').style.display = 'none';
                    
                    // Check if there are more products
                    if (!data.hasMore) {
                        hasMore = false;
                        document.getElementById('end-message').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error loading more products:', error);
                    loading = false;
                    document.getElementById('loading').style.display = 'none';
                });
        }
    });
</script>
@endsection
