<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\CarouselController;
use App\Http\Controllers\Api\V1\CategoriesController;
use App\Http\Controllers\Api\V1\CustomerHistoryController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\OrderDetailController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ProductCategoriesController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProductDetailController;
use App\Http\Controllers\Api\V1\PromoController;
use App\Http\Controllers\Api\V1\RestockFromWarehouseLogsController;
use App\Http\Controllers\Api\V1\RestockLogController;
use App\Http\Controllers\Api\V1\ShippingController;
use App\Http\Controllers\Api\V1\ShoppingCartController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes
Route::group(['prefix' => 'v1'], function() {
    // Register User
    Route::post('register', [UserController::class, 'store']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('password/reset', [UserController::class, 'reset']);

    // Index routes
    Route::get('products', [ProductController::class, 'index']);
    Route::get('product-details', [ProductDetailController::class, 'index']);
    Route::get('product-categories', [ProductCategoriesController::class, 'index']);
    Route::get('categories', [CategoriesController::class, 'index']);
    Route::get('promos', [PromoController::class, 'index']);
    Route::get('carousels', [CarouselController::class, 'index']);

    // Show routes
    Route::get('products/{product}', [ProductController::class, 'show']);
    Route::get('product-details/{product_detail}', [ProductDetailController::class, 'show']);
    Route::get('product-categories/{product_category}', [ProductCategoriesController::class, 'show']);
    Route::get('categories/{category}', [CategoriesController::class, 'show']);
    Route::get('promos/{promo}', [PromoController::class, 'show']);
    Route::get('carousels/{carousel}', [CarouselController::class, 'show']);

    Route::get('admin-wa', [UserController::class, 'getAdminWa']);
});

// Protected Routes
Route::group(['middleware' => 'auth:sanctum'], function(){
    // api/v1
    Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
        // Orders
        Route::apiResource('orders', OrderController::class)->except(['destroy']);
        Route::get('orders/{order_id}/invoice', [OrderController::class, 'orderInvoice']);
        // Route::post('orders/bulk', [OrderController::class, 'bulkStore']);

        // Order Details
        Route::apiResource('order-details', OrderDetailController::class)->except(['store','update','destroy']);
        // Route::post('order-details/bulk', [OrderDetailController::class, 'bulkStore']);
        
        // Users
        Route::apiResource('users', UserController::class)->except(['store','destroy']);
        Route::post('logout', [UserController::class, 'logout']);
        // Route::post('users/bulk', [UserController::class, 'bulkStore']);
        
        // Products
        // Route::post('products/bulk', [ProductController::class, 'bulkStore']);
        
        // Product Details
        // Route::post('products-details/bulk', [ProductDetailController::class, 'bulkStore']);
        
        // Product Categories
        // Route::post('product-categories/bulk', [ProductCategoriesController::class, 'bulkStore']);
        
        // Shopping Carts
        Route::apiResource('shopping-carts', ShoppingCartController::class);
        // Route::post('shopping-carts/bulk', [ShoppingCartController::class, 'bulkStore']);
        
        // Categories
        // Route::post('categories/bulk', [CategoriesController::class, 'bulkStore']);
        
        // Payments
        Route::apiResource('payments', PaymentController::class)->except(['store','destroy']);
        // Route::post('payments/bulk', [PaymentController::class, 'bulkStore']);
        
        // Promos
        // Route::post('promos/bulk', [PromoController::class, 'bulkStore']);
        
        // Carousels
        // Route::post('carousels/bulk', [CarouselController::class, 'bulkStore']);
        
        // Shippings
        Route::apiResource('shippings', ShippingController::class)->except(['store','destroy']);
        // Route::post('shippings/bulk', [ShippingController::class, 'bulkStore']);
        
        // Restock from Warehouse Logs
        // Route::post('restock-from-warehouse-logs/bulk', [RestockFromWarehouseLogsController::class, 'bulkStore']);
        
        // Restock Logs
        // Route::post('restock-logs/bulk', [RestockLogController::class, 'bulkStore']);

        //Addresses
        Route::apiResource('addresses', AddressController::class);

        //Customer Histories
        Route::apiResource('customer-histories', CustomerHistoryController::class)->except(['store','update','destroy']);
    });
});

