<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessHoursController;

// Route::get('/', function () {
//     return view('welcome');
// });



// Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('admin/menu',function(){
    return view('admin.menu');
});

Route::get('admin/orders',function(){
    return view('admin/orders');
});

Route::get('admin/take-payment',function(){
    return view('admin/take-payment');
});

Route::get('admin/website-status',function(){
    return view('admin/website-status');
});

Route::get('admin/customers',function(){
    return view('admin/customers');
});

Route::get('admin/business-hours',function(){
    return view('admin/business-hours');
});

Route::get('admin/delivery-configuration',function(){
    return view('admin/delivery-configuration');
});

Route::get('admin/reviews',function(){
    return view('admin/reviews');
});

Route::get('admin/billing',function(){
    return view('admin/billing');
});

Route::get('admin/reports',function(){
    return view('admin/reports');
});


//BusinessHours
 Route::get('admin/business-hours', [BusinessHoursController::class, 'index'])->name('BusinessHours');
    Route::post('/shifts', [BusinessHoursController::class, 'store'])->name('store');
    Route::put('/shifts/{shift}', [BusinessHoursController::class, 'update'])->name('update');
    Route::delete('/shifts/{shift}', [BusinessHoursController::class, 'destroy'])->name('destroy');

  
//menus
Route::get('/admin/menus', function () {
    return view('admin.menus');
});

Route::get('/admin/menus/load/{page}', function ($page) {
    return view("admin.menus.$page");
});

Route::get('/admin/add-category',function(){
    return view('admin.menus.add-update-menus.add-category');
})->name('add-category');




//Client
Route::get('client/orders',function(){
    return view('client.orders');
});

Route::get('client/layout',function(){
    return view('client.layout');
});

