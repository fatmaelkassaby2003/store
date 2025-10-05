<?php

use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProductController ;
use App\Http\Controllers\Dashboard\ProfitController;

Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {
    Route::get('/users', [UserController::class, 'getUsers'])->name('dashboard.users');
    Route::get('/products', [ProductController::class, 'getproducts'])->name('dashboard.products');
    Route::get('/orders', [OrderController::class, 'getorders'])->name('dashboard.orders');
    Route::get('/companies', [CompanyController::class, 'getcompanies'])->name('dashboard.companies');
    Route::get('/employees', [UserController::class, 'getemployees'])->name('dashboard.employees');
    Route::get('/product/{id}', [ProductController::class, 'productshow'])->name('products.view');
    Route::get('/order/{id}', [OrderController::class, 'ordershow'])->name('order.view');
    Route::get('/user/{id}', [UserController::class, 'usershow'])->name('user.view');
    Route::get('/profit', [ProfitController::class, 'gerProfits'])->name('dashboard.profits');

    Route::post('/order-company', [ProductController::class, 'ProductQuantity'])->name('company.store');
    Route::post('/add-product', [ProductController::class, 'addproduct'])->name('product.add');
    Route::post('/add-user', [UserController::class, 'adduser'])->name('user.add');
    Route::post('/add-company', [CompanyController::class, 'addcompany'])->name('company.add');
    Route::post('/delete-employee/{id}', [UserController::class, 'deleteemployee'])->name('employee.delete');
    Route::post('/delete-product/{id}', [ProductController::class, 'deleteproduct'])->name('product.delete');
    Route::post('/add-discount/{id}', [ProductController::class, 'adddiscount'])->name('product.discount');

    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/approve', [OrderController::class, 'approve'])->name('orders.approve');

});
