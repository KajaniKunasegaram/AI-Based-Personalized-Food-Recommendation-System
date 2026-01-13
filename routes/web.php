<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessHoursController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ModifierGroupController;
use App\Http\Controllers\ModifierController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\Admin\MenuLoaderController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\AdOrderController;
use App\Http\Controllers\Admin\AdCustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DeliveryBoysController;




use App\Http\Controllers\Client\CartController;
// use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\CustomerController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ContactController;

use App\Http\Controllers\Client\OrderController;



use App\Models\CategoryModel;
use App\Models\ModifierGroupModel;






// Admin Routes

// Route::get('/', function () {
//     return redirect()->to('/admin/orders');
// });

Route::get('/', function () {
    return redirect()->route('admin.login');
});


Route::get('/admin/logout', function () {
    session()->forget([
        'admin_otp',
        'admin_otp_verified'
    ]);

    return redirect()->route('admin.login');
})->name('admin.logout');
// Route::get('/admin/dashboard', fn() => view('admin.dashboard'));



Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('admin.login');

// Safety: redirect GET request to login
Route::get('/admin/send-otp', function() {
    return redirect()->route('admin.login');
});

Route::post('/admin/send-otp', [AuthController::class, 'sendOtp'])->name('admin.sendOtp');
Route::post('/admin/verifyOtp', [AuthController::class, 'verifyOtp'])->name('admin.verifyOtp');

Route::middleware(['admin.otp'])->group(function () {
    Route::get('/admin/orders', function () {
        return view('admin.orders');
    })->name('admin.orders');
});




Route::get('admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');
/* MENU (IMPORTANT FIX) */
Route::get('/admin/menu', [CategoryController::class, 'menus']);

/* Other admin pages */
// Route::get('admin/orders', fn() => view('admin.orders'));
Route::prefix('admin')->group(function () {
    Route::get('/orders', [AdOrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{id}', [AdOrderController::class, 'show']);
    Route::post('/orders/{id}/status', [AdOrderController::class, 'updateStatus']);
});


Route::get('admin/take-payment', fn() => view('admin.take-payment'));
Route::get('admin/website-status', fn() => view('admin.website-status'));
// Route::get('admin/customers', fn() => view('admin.customers'));

Route::get('admin/customers', [AdCustomerController::class, 'index'])
    ->name('admin.customers');


// Route::get('admin/reviews', fn() => view('admin.reviews'));
Route::get('admin/billing', fn() => view('admin.billing'));
Route::get('admin/reports', fn() => view('admin.reports'));
Route::get('admin/support', fn() => view('admin.support'));
Route::get('admin/settings', fn() => view('admin.settings'));
Route::get('admin/terms-and-policy', fn() => view('admin.terms-and-policy'));

// Admin reviews list
Route::get('admin/reviews', [ReviewController::class, 'indexAdmin'])->name('admin.reviews');
Route::delete('admin/reviews/{id}', [ReviewController::class, 'destroy'])->name('admin.reviews.delete');




/*  Business Hours */
Route::get('admin/business-hours', [BusinessHoursController::class, 'index'])
    ->name('BusinessHours');

Route::post('/shifts', [BusinessHoursController::class, 'store'])->name('store');
Route::put('/shifts/{shift}', [BusinessHoursController::class, 'update'])->name('update');
Route::delete('/shifts/{shift}', [BusinessHoursController::class, 'destroy'])->name('destroy');


Route::get('/admin/menus/load/{page}',
    [MenuLoaderController::class, 'load']
);

// Categories  
Route::prefix('admin/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Route::get('/admin/sub-categories/create/{cat_id?}', [SubCategoryController::class, 'create'])->name('subCategories.create');

// sub categories
Route::prefix('admin/sub-categories')->group(function () {
    Route::get('/', [SubCategoryController::class, 'index'])->name('subCategories.index');
    Route::get('/create/{cat_id?}', [SubCategoryController::class, 'create'])->name('subCategories.create');
    Route::post('/store', [SubCategoryController::class, 'store'])->name('subCategories.store');
    Route::get('/{id}/edit', [SubCategoryController::class, 'edit'])->name('subCategories.edit');
    Route::put('/{id}', [SubCategoryController::class, 'update'])->name('subCategories.update');
    Route::delete('/{id}', [SubCategoryController::class, 'destroy'])->name('subCategories.destroy');
});

// Items
Route::prefix('admin/items')->group(function () {
    Route::get('/create/{sub_cat_id}', [ItemController::class, 'create'])->name('items.create');
    Route::post('/store', [ItemController::class, 'store'])->name('items.store');
    Route::get('/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
});

Route::post('/admin/items/{id}/status',[ItemController::class, 'updateStatus'])->name('items.status');


Route::prefix('admin/modifier-groups')->group(function () {
    Route::get('/', [ModifierGroupController::class, 'index'])->name('modifier-groups.index');
    Route::get('/create', [ModifierGroupController::class, 'create'])->name('modifier-groups.create');
    Route::post('/store', [ModifierGroupController::class, 'store'])->name('modifier-groups.store');
    Route::get('/edit/{id}', [ModifierGroupController::class, 'edit'])->name('modifier-groups.edit');
    Route::put('/update/{id}', [ModifierGroupController::class, 'update'])->name('modifier-groups.update');
    Route::delete('/delete/{id}', [ModifierGroupController::class, 'destroy'])->name('modifier-groups.delete');
});

// Modifiers CRUD
Route::prefix('admin/modifiers')->group(function () {
    Route::post('/store', [ModifierController::class, 'store'])->name('modifiers.store');
    Route::post('/update/{id}', [ModifierController::class, 'update'])->name('modifiers.update');
    Route::delete('/destroy/{id}', [ModifierController::class, 'destroy'])->name('modifiers.destroy');
});



Route::prefix('admin')->group(function () {
    Route::get('/delivery-config', [DeliveryController::class, 'index']);
    Route::post('/delivery-config', [DeliveryController::class, 'store']);
    Route::get('/delivery-config/{id}', [DeliveryController::class, 'show']);
    Route::post('/delivery-config/update/{id}', [DeliveryController::class, 'update']);
    Route::delete('/delivery-config/{id}', [DeliveryController::class, 'destroy']);
});


Route::get('/admin/delivery-boys', [DeliveryBoysController::class, 'index']);
Route::post('/admin/delivery-boys', [DeliveryBoysController::class, 'store']);
Route::get('/admin/delivery-boys/{id}', [DeliveryBoysController::class, 'edit']);
Route::post('/admin/delivery-boys/update/{id}', [DeliveryBoysController::class, 'update']);
Route::delete('/admin/delivery-boys/{id}', [DeliveryBoysController::class, 'destroy']);








/* Client */
Route::get('client/orders', [OrderController::class, 'index'])->name('orders');
Route::get('client/item/{id}', [OrderController::class, 'getItem']);

Route::get('client/layout', fn() => view('client.layout'));

Route::get('/checkout', [CartController::class, 'view'])->name('checkout');
Route::post('/cart/save', [CartController::class, 'save'])->name('cart.save');
Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.update.qty');


Route::post('/cart/item/delete', [CartController::class, 'deleteItem'])->name('cart.item.delete');
Route::post('/cart/modifier/delete', [CartController::class, 'deleteModifier'])->name('cart.modifier.delete');


Route::post('/stripe/create-session', [PaymentController::class, 'createSession'])->name('stripe.session');
Route::get('/stripe/success', [PaymentController::class, 'success'])->name('stripe.success');
Route::get('/stripe/cancel', [PaymentController::class, 'cancel'])->name('stripe.cancel');


Route::get('/order/success', [\App\Http\Controllers\Client\PaymentController::class, 'cashSuccess'])
    ->name('orders.success');


Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');



Route::get('/about', function() {
    return view('client.about'); // Make sure the blade file is review.blade.php
})->name('about');



Route::get('/more', function () {
    if(!session()->has('customer_id')){
        return redirect()->route('login'); // redirect if not logged in
    }
    return view('client.more');
})->name('more');



Route::post('client/contact-submit', [ContactController::class, 'submit'])->name('client.contact.submit');

Route::get('client/contact', [ContactController::class, 'index'])->name('client.contact');


Route::get('/login', function () {
    return view('client.login');
})->name('login');


Route::get('/register', function () {
    return view('client.register');
})->name('register');

Route::post('/customer/login', [CustomerController::class, 'login'])->name('customer.login');
Route::post('/customer/register', [CustomerController::class, 'register'])->name('customer.register');
Route::post('/customer/delete', [CustomerController::class, 'deleteAccount'])->name('customer.delete');
Route::get('/customer/logout', [CustomerController::class, 'logout'])->name('customer.logout');

