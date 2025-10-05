<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\E_commerce\{ProductController, CartController, CheckoutController, OrderController, ContactController, ProfileController};
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\ProductController as DashboardProductController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Cashier\CashierController ;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Payment\PaymentController;
use App\Models\Product;


Route::get('/get-product/{code}', function ($code) {
    $product = Product::where('code', $code)->first();
    return response()->json($product);
});

/////////products
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/get-products/{category}', [ProductController::class, 'getProductsByCategory']);
Route::get('/search-products', [ProductController::class, 'search'])->name('search.products');
Route::get('/product-details/{id}', [ProductController::class, 'getProductDetails'])->name('product.details');
Route::get('/shop-single/{id}', [ProductController::class, 'show'])->name('shop.single');
Route::get('/upload/{id}', [ProductController::class, 'show'])->name('upload.form');
Route::post('/upload-image/{productId}', [ProductController::class, 'upload'])->name('image.upload');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/shop/product/{id}', [ProductController::class, 'shopsingle'])->name('shop-single');

/////////cashier
Route::get('/cashier', [CashierController::class, 'index'])->middleware('employee')->name('cashier');
Route::post('/cashier/store', [CashierController::class, 'store'])->name('cashier.store');

///////auth
Route::get('/register', function () { return view('register'); })->name('register');
Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register-form');
Route::post('/login', [AuthController::class, 'login'])->name('login-form');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//////search
Route::get('/products.list', [DashboardProductController::class, 'product'])->name('products.list');
Route::get('/employees.list', [UserController::class, 'employees'])->name('employees.list');
Route::get('/companies.list', [CompanyController::class, 'companies'])->name('companies.list');

////////cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/update/{id}/{change}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('apply.discount');



Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::post('/checkout/place-order', [OrderController::class, 'placeOrder'])->name('checkout.placeOrder');


Route::post('/contact', [ContactController::class, 'store'])->middleware('auth')->name('contact.store');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/thankyou', function () { return view('thankyou'); })->name('thankyou');
Route::get('/about', function () { return view('about'); })->name('about');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/change', [PasswordController::class, 'changePassword'])->name('password.update');

    ///////////////////////
    Route::get('/paymob/pay', [PaymentController::class, 'initPayment'])->name('paymob.pay');
    Route::post('/paymob/callback', [PaymentController::class, 'callback'])->name('paymob.callback');
});