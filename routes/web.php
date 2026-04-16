<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\RestockFromWarehouseLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ShoppingCartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RestockLogController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/load-more-products', [HomeController::class, 'loadMoreProducts'])->name('load-more-products');
Route::get('/all-products', [HomeController::class, 'allProducts'])->name('all-products');
Route::get('/detail-products/{product_id}', [HomeController::class, 'detailProduct'])->name('detail-product');
Route::get('/search-products', [HomeController::class, 'searchProducts'])->name('search-products');

Route::group(['middleware'=>'customer'], function(){
    Route::post('/add-to-cart', [ShoppingCartController::class, 'addToCart'])->name('cart.add');
    Route::get('/shopping-carts/{user_id}', [ShoppingCartController::class, 'index'])->name('shopping-carts');
    Route::patch('/cart/{id}', [ShoppingCartController::class, 'update']);
    Route::delete('/cart/{id}', [ShoppingCartController::class, 'destroy']);
    Route::get('/check-order',[CustomerOrderController::class, 'checkOrder']);
    Route::post('/encrypt-data', [CustomerOrderController::class, 'encryptData'])->name('encrypt-carts');
    Route::post('/check-promo-code', [CustomerOrderController::class, 'checkPromo'])->name('check-promo-code');
    Route::post('/calculate-total', [CustomerOrderController::class, 'calculateTotal'])->name('calculate-total');
    Route::get('/addresses-list/{address_id}',[CustomerOrderController::class, 'addressesList']);
    Route::get('/submit-payment-page',[CustomerOrderController::class, 'submitPaymentPage']);
    Route::post('/submit-payment/{order_id}',[CustomerOrderController::class, 'submitPayment']);
    Route::post('/place-order', [CustomerOrderController::class, 'placeOrder'])->name('place-order');
    Route::get('/invoice/{order_id}',[CustomerOrderController::class, 'invoice']);
    Route::get('/invoice-print/{order_id}',[CustomerOrderController::class, 'invoicePrint']);
    Route::get('/my-account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/my-account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::get('/add-address-page', [AccountController::class, 'addAddressPage']);
    Route::post('/create-address', [AccountController::class, 'createAddress']);
    Route::post('/set-default-address', [AccountController::class, 'setDefaultAddress'])->name('address.setDefault');
    Route::post('/update-password/{user_id}', [AccountController::class, 'updatePassword']);

});


Route::group(['middleware' => ['guest']],function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'doRegister'])->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'doLogin'])->name('login');
    Route::get('password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.email');
});

Route::group(['middleware'=>'auth'], function(){
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function(){
    Route::get('/orders/monthly', [AdminController::class, 'monthlyOrders'])->name('admin.orders.monthly');
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
    Route::post('/notifications/mark-as-read', [AdminController::class, 'markAsRead']);
    Route::resource('/products', ProductController::class);
    Route::resource('/product-details', ProductDetailController::class)->except(['create','index','show']);
    Route::get('/product-details/create/{product}', [ProductDetailController::class, 'create'])
    ->name('product-details.create');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/product-categories', ProductCategoryController::class)->except(['index','show','edit','update']);
    Route::resource('/promos', PromoController::class)->except(['show']);
    Route::resource('/shippings', ShippingController::class)->except(['index','create','store','edit','destroy']);
    Route::resource('/restock-logs', RestockLogController::class)->except(['show','create','store','edit','update']);
    Route::resource('/restock-from-warehouse-logs', RestockFromWarehouseLogController::class)->except(['create','edit','update']);
    Route::resource('/carousels', CarouselController::class)->except(['show']);
    Route::post('/carousels/set-popup', [CarouselController::class, 'setPopUp']);
    Route::resource('/orders', OrderController::class)->except(['create','store','edit','update']);
    Route::resource('/payments', PaymentController::class)->except(['index','create','store','edit','destroy']);
    Route::resource('/revenues', RevenueController::class);
    Route::resource('/users', UserController::class);
    // Route::get('/users/{user_id}/verify-email', [UserController::class, 'verifyEmail']);
    // Route::get('/users/verify-email-code/{id}/{code}', [UserController::class, 'verifyEmailCode'])->name('user.verify');
});

Route::group(['prefix' => 'admin', 'middleware' => 'all-admin'], function(){
    // Routes for managing users
    Route::resource('/users', UserController::class)->except(['create','store','destroy']);
    Route::get('/users/{user_id}/change-password', [UserController::class, 'changePassword']);
    Route::post('/users/{user_id}/update-password', [UserController::class, 'updatePassword']);
    Route::get('/generate-invoice/{shipping_id}', [ShippingController::class, 'generateInvoice']);

    // Other routes specific to admin or warehouse-admin can be added here
});
Route::group(['prefix' => 'warehouse-admin', 'middleware' => 'warehouse-admin'], function(){
    Route::get('/', function () {
        return redirect()->route('orders.index');
    })->name('warehouse-admin');
    Route::resource('/orders', WarehouseController::class)->except(['create','store','edit','destroy']);
    Route::get('/order-detail/{id}', [WarehouseController::class, 'showOrderDetail']);
    Route::get('/order-histories', [WarehouseController::class, 'orderHistories']);
});