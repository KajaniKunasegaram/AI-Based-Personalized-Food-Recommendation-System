<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessHoursController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ModifierGroupController;
use App\Http\Controllers\Admin\MenuLoaderController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\ModifierController;


use App\Models\CategoryModel;
use App\Models\ModifierGroupModel;




// Admin Routes


Route::get('/admin/dashboard', fn() => view('admin.dashboard'));

/* MENU (IMPORTANT FIX) */
Route::get('/admin/menu', [CategoryController::class, 'menus']);

/* Other admin pages */
Route::get('admin/orders', fn() => view('admin.orders'));
Route::get('admin/take-payment', fn() => view('admin.take-payment'));
Route::get('admin/website-status', fn() => view('admin.website-status'));
Route::get('admin/customers', fn() => view('admin.customers'));

Route::get('admin/reviews', fn() => view('admin.reviews'));
Route::get('admin/billing', fn() => view('admin.billing'));
Route::get('admin/reports', fn() => view('admin.reports'));
Route::get('admin/support', fn() => view('admin.support'));
Route::get('admin/settings', fn() => view('admin.settings'));
Route::get('admin/terms-and-policy', fn() => view('admin.terms-and-policy'));

/*  Business Hours */
Route::get('admin/business-hours', [BusinessHoursController::class, 'index'])
    ->name('BusinessHours');

Route::post('/shifts', [BusinessHoursController::class, 'store'])->name('store');
Route::put('/shifts/{shift}', [BusinessHoursController::class, 'update'])->name('update');
Route::delete('/shifts/{shift}', [BusinessHoursController::class, 'destroy'])->name('destroy');



/* Menu AJAX Loader */
// Route::get('/admin/menus/load/{page}', function ($page) {

//     if ($page === 'menus') {
//         $categories = CategoryModel::orderBy('cat_id','desc')->get();
//         return view('admin.menus.menus', compact('categories'));
//     }

//     return view("admin.menus.$page");
// });

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




// Route::get('/admin/menus/load/{page}', function ($page) {

//     if ($page === 'modifier-groups') {
//         $groups = ModifierGroupModel::all();
//         return view("admin.menus.$page", compact('groups'));
//     }

//     return view("admin.menus.$page");
// });

// Route::get(
//     '/admin/menus/load/{page}',
//     [MenuLoaderController::class, 'load']
// );

// Route::get('/admin/modifier-groups',
//     [ModifierGroupController::class, 'index']
// )->name('modifier-groups.index');

// Route::get('/admin/menus/load/{page}', function ($page) {

//     if ($page === 'modifier-groups') {
//         $groups = ModifierGroupModel::all();
//         return view("admin.menus.$page", compact('groups'));
//     }

//     return view("admin.menus.$page");
// });


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
// Route::prefix('admin')->group(function () {
// // MODIFIER GROUPS

//     // List page
//     Route::get('/modifier-groups',
//         [ModifierGroupController::class, 'index']
//     )->name('modifier-groups.index');

//     // Add view
//     Route::get('/modifier-groups/create',
//         [ModifierGroupController::class, 'create']
//     )->name('modifier-groups.create');

//     // Store
//     Route::post('/modifier-groups/store',
//         [ModifierGroupController::class, 'store']
//     )->name('modifier-groups.store');

//     // Edit view
//     Route::get('/modifier-groups/edit/{id}',
//         [ModifierGroupController::class, 'edit']
//     )->name('modifier-groups.edit');

//     // Update
//     Route::post('/modifier-groups/update/{id}',
//         [ModifierGroupController::class, 'update']
//     )->name('modifier-groups.update');

// });



// Route::prefix('admin')->group(function () {

//     Route::post('/modifiers/store',
//         [ModifierController::class, 'store']
//     )->name('modifiers.store');

//     Route::post('/modifiers/update/{id}',
//         [ModifierController::class, 'update']
//     )->name('modifiers.update');

//     Route::delete('/modifiers/delete/{id}',
//         [ModifierController::class, 'destroy']
//     )->name('modifiers.delete');

// });



Route::prefix('admin')->group(function () {
    Route::get('/delivery-config', [DeliveryController::class, 'index']);
    Route::post('/delivery-config', [DeliveryController::class, 'store']);
    Route::get('/delivery-config/{id}', [DeliveryController::class, 'show']);
    Route::post('/delivery-config/update/{id}', [DeliveryController::class, 'update']);
    Route::delete('/delivery-config/{id}', [DeliveryController::class, 'destroy']);
});

/* Client */
Route::get('client/orders', fn() => view('client.orders'));
Route::get('client/layout', fn() => view('client.layout'));
