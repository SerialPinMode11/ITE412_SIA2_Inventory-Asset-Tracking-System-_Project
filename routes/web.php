<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\Access\SupplierAccessController;
use App\Http\Controllers\Access\InspectorateAccessController;
use App\Http\Controllers\Admin\PhysicalAssetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you register web routes for your application.
| These routes are protected by middleware for authentication and roles.
|
*/

// 🏠 Public Welcome Page
Route::view('/', 'welcome')->name('home');

// New Public Access Routes (from the modal)

Route::get('/access/inspectorate', function () {
    return view('access.inspectorate');
})->name('access.inspectorate');

// NOTE: You had two definitions for '/access/supplier'. One has been removed, 
// and the redirect logic is kept for the single route definition.
Route::get('/access/supplier', function () {
    // This route redirects to the main PO Status page
    return redirect()->route('supplier.po.index');
})->name('access.supplier');


// NEW: Supplier PO Status Routes (Public, Read-Only)
// FIX: Changed Route::group(['prefix' => '...', 'name' => '...'], ...)
// TO: Route::prefix('...')->name('...')->group(...)
Route::prefix('supplier-portal')->name('supplier.po.')->group(function () {
    // These names are now correctly generated as: supplier.po.index, supplier.po.show
    Route::get('/', [SupplierAccessController::class, 'index'])->name('index');
    Route::get('/{purchaseOrder}', [SupplierAccessController::class, 'show'])->name('show');
});


// New Public Access Routes (from the modal)
// We change the static view to the controller's index
Route::get('/access/inspectorate', [InspectorateAccessController::class, 'index'])->name('access.inspectorate.index'); 

// NEW: Inspectorate Report Submission Routes (Public)
Route::prefix('inspectorate-portal')->name('access.inspectorate.')->group(function () {
    // Index is handled above, but we define the other actions
    Route::get('/report/create/{purchaseOrder}', [InspectorateAccessController::class, 'createReport'])->name('create');
    Route::post('/report/store/{purchaseOrder}', [InspectorateAccessController::class, 'storeReport'])->name('store');
});



// 🔐 Guest-only routes (when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthenticateController::class, 'registerForm'])->name('register.form');
    Route::post('/register', [AuthenticateController::class, 'register'])->name('register.submit');
    
    Route::get('/login', [AuthenticateController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [AuthenticateController::class, 'login'])->name('login.submit');
});

// ✅ Authenticated routes
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthenticateController::class, 'logout'])->name('logout');

    // 🧍‍♂️ User Dashboard
    Route::view('/dashboard', 'user.dashboard')->name('user.dashboard');

    // 🧑‍💼 Admin-only pages
    // The admin routes use simple group without prefix/name to keep the names explicitly defined
    Route::middleware('role:admin')->group(function () {
        Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');

        // Inventory Routes (Explicitly named and URI prefixed)
        // 2. Inventory Index
        Route::get('/admin/inventory', [PhysicalAssetController::class, 'index'])->name('admin.inventory.index');
        
        // 3. Explicit CRUD Routes
        Route::get('/admin/inventory/create', [PhysicalAssetController::class, 'create'])->name('admin.inventory.create');
        Route::post('/admin/inventory', [PhysicalAssetController::class, 'store'])->name('admin.inventory.store');
        
        // {inventory} is the route model binding variable name used by the controller
        Route::get('/admin/inventory/{inventory}', [PhysicalAssetController::class, 'show'])->name('admin.inventory.show');
        Route::get('/admin/inventory/{inventory}/edit', [PhysicalAssetController::class, 'edit'])->name('admin.inventory.edit');
        Route::put('/admin/inventory/{inventory}', [PhysicalAssetController::class, 'update'])->name('admin.inventory.update');
        Route::delete('/admin/inventory/{inventory}', [PhysicalAssetController::class, 'destroy'])->name('admin.inventory.destroy');
    });

    // 👀 Viewer pages
    Route::middleware('role:viewer')->group(function () {
        Route::view('/viewer/report', 'viewer.report')->name('viewer.report');
    });
});