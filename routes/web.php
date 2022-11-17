<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth2\RegisterController;
use App\Http\Controllers\Auth2\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Adm\UserController;
use App\Http\Controllers\Adm\CategoryController;
use App\Http\Controllers\Adm\ManufacturerController;
use App\Http\Controllers\Adm\RoleController;
use App\Http\Controllers\BasketController;


Route::get('/', function () {
    return redirect()->route('shops.index');
});
    Route::middleware('auth')->group(function (){
        Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
        Route::get('/shops', [ShopController::class, 'show'])->name('shops.show');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::resource('/comments', CommentController::class)->only('store', 'destroy');
        Route::post('/shops/{shop}/rate', [ShopController::class, 'rate'])->name('shops.rate');
        Route::post('/shops/{shop}/unrate', [ShopController::class, 'unrate'])->name('shops.unrate');

        Route::prefix('adm')->as('adm.')->middleware('hasrole:admin,moderator')->group(function (){

            Route::resource('/category', CategoryController::class);
            Route::resource('/manufacturer', ManufacturerController::class);
            Route::resource('/roles', RoleController::class);

            Route::put('/shops/product', [ShopController::class, 'product'])->name('shops.product');
            Route::get('/shops/search', [ShopController::class, 'product'])->name('shops.search');
            Route::put('/shops/{shop}', [ShopController::class, 'update'])->name('shops.update');
            Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
            Route::get('/shops{shop}/edit', [ShopController::class, 'edit'])->name('shops.edit');
            Route::post('/shops/store', [ShopController::class, 'store'])->name('shops.store');
            Route::delete('/shops/{shop}', [ShopController::class, 'destroy'])->name('shops.destroy');


            Route::get('/shops/product', [ShopController::class, 'product'])->name('product');
            Route::get('/users', [UserController::class, 'index'])->name('users');
            Route::get('/users/search', [UserController::class, 'index'])->name('users.search');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::put('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
            Route::put('/users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
    });
});
Route::resource('/shops', ShopController::class)->only('index', 'show');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/shops/manufacturer/{manufacturer}', [ShopController::class, 'shopManufacturer'])->name('shops.manufacturer');
Route::get('/shops/category/{category}', [ShopController::class, 'shopCategory'])->name('shops.category');

Route::get('/register', [RegisterController::class, 'create'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'create'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');