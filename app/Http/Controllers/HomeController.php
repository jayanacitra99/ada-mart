<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ShoppingCart;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productsPromo = Product::with(['productDetails.promo','productDetails.shoppingCarts'])
                                ->whereHas('productDetails', function($q){
                                    $q->whereHas('promo', function($subq){
                                        $subq->byActive();
                                    });
                                })
                                ->take(8)
                                ->get();
        $data = [
            'carousels'     => Carousel::byActive()->get(),
            'categories'    => Categories::whereHas('productCategories')->get(),
            'productsPromo' => $productsPromo,
            'products'      => Product::with('productDetails.shoppingCarts')->whereHas('productDetails')->orderBy('id','desc')->take(8)->get(),
        ];
        return view('Customer.home', $data);
    }

    public function allProducts(Request $request)
    {
        $query = $request->input('search', null);
        $isPromo = $request->input('promo', false);
        $categoryId = $request->input('category_id', null);

        $productsQuery = Product::with(['productDetails','productCategories'])
            ->whereHas('productDetails', function($query) use ($isPromo) {
                if ($isPromo) {
                    $query->whereHas('promo', function($q) {
                        $q->byActive();
                    });
                }
            });
        if ($query) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%');
            });
        }
        if ($categoryId) {
            $productsQuery->whereHas('productCategories', function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        $products = $productsQuery->orderBy('id', 'desc')->take(15)->get();

        if ($isPromo) {
            $title = 'Promo';
        } else if (!\is_null($categoryId)){
            $title = Categories::find($categoryId)->name;
        } else {
            $title = 'Products';
        }

        $data = [
            'totalProducts'     => $productsQuery->count(),
            'products'          => $products,
            'isPromo'           => $isPromo,
            'categoryId'        => $categoryId,
            'title'             => $title,
            'search'            => $query,
        ];

        return view('Customer.all_products', $data);
    }


    public function loadMoreProducts(Request $request)
    {
        $skip = $request->input('skip', 0);
        $isPromo = $request->input('promo', false);
        $categoryId = $request->input('category_id', null);
        $query = $request->input('search', null);

        $productsQuery = Product::with('productDetails')
            ->whereHas('productDetails', function($query) use ($isPromo) {
                if ($isPromo) {
                    $query->whereHas('promo', function($q) {
                        $q->byActive();
                    });
                }
            });
        if (!\is_null($query)) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%');
            });
        }
        if (!\is_null($categoryId)) {
            $productsQuery->whereHas('productCategories', function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        $products = $productsQuery->orderBy('id', 'desc')->skip($skip)->take(15)->get();
        // Check if there are more products to load
        $hasMore = $productsQuery->skip($skip + 15)->exists();

        return response()->json([
            'html' => view('Customer.product_items', compact('products'))->render(),
            'hasMore' => $hasMore
        ]);
    }

    public function detailProduct($product_id)
    {
        $data = [
            'product'   => Product::with('productDetails')->find($product_id),
        ];
        return view('Customer.detail_product', $data);
    }
}
