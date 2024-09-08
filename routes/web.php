<?php

use App\Livewire\Admpage;
use App\Livewire\Cart as LivewireCart;
use App\Livewire\Category;
use App\Livewire\Mainpage;
use App\Livewire\Orders;
use App\Livewire\Productlist;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', Mainpage::class);
Route::get('/admin', Admpage::class)->middleware('auth');
Route::get('/productlist/{category}', Productlist::class)->name('productlist');
Route::get('/cart', LivewireCart::class)->middleware('auth');
Route::get('/orders', Orders::class)->name('myOrders')->middleware('auth');
