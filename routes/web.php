<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\Access\SupplierAccessController;
use App\Http\Controllers\Access\InspectorateAccessController;
use App\Http\Controllers\Admin\PhysicalAssetController;
use App\Http\Controllers\User\RequisitionerController;
use App\Http\Controllers\Admin\RequisitionManagementController;
use App\Http\Controllers\Admin\ProcurementController;
use App\Http\Controllers\Viewer\SupplyHeadController;

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
Route::get('/access/inspectorate/pending', [InspectorateAccessController::class, 'view_pending'])->name('access.inspectorate.pending'); 
Route::get('/access/inspectorate', [InspectorateAccessController::class, 'index'])->name('access.inspectorate.index');
Route::get('/access/inspectorate/form/{purchaseOrder}', [InspectorateAccessController::class, 'createReport'])->name('access.inspectorate.create');
Route::post('/report/create/{purchaseOrder} ', [InspectorateAccessController::class, 'storeReport'])->name('access.inspectorate.store');
Route::get('/access/inspectorate/create-pending', [InspectorateAccessController::class, 'createPending'])->name('access.inspectorate.create_pending');
Route::post('/access/inspectorate/store-pending', [InspectorateAccessController::class, 'storePending'])->name('access.inspectorate.store_pending');
Route::get('/access/inspectorate/successful', [InspectorateAccessController::class, 'view_successful'])->name('access.inspectorate.successful');



// // NEW: Inspectorate Report Submission Routes (Public)
// Route::prefix('inspectorate-portal')->name('access.inspectorate.')->group(function () {
//      // 1. Landing Page (The initial page with the feature cards) - Name: access.inspectorate.index
//     Route::get('/', [InspectorateAccessController::class, 'index'])->name('index'); 

//     // 2. Pending Deliveries List - Name: access.inspectorate.pending
//     Route::get('/pending', [InspectorateAccessController::class, 'view_pending'])->name('pending');

//     // 3. Create Report Form (Receives the PO to inspect) - Name: access.inspectorate.create
//     // This route MUST receive the PurchaseOrder model (Route Model Binding)
//     Route::get('/report/create/{purchaseOrder}', [InspectorateAccessController::class, 'createReport'])->name('create');

//     // 4. Store Report Submission - Name: access.inspectorate.store
//     // This route MUST receive the PurchaseOrder model to link the report
//     Route::post('/report/store/{purchaseOrder}', [InspectorateAccessController::class, 'storeReport'])->name('store');
// });



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

    // 🧍‍♂️ User Dashboard Pages
    Route::view('/dashboard', 'user.dashboard')->name('user.dashboard');

    // Asset Request Routes
    Route::get('/requests', [RequisitionerController::class, 'index'])->name('user.requests.index');
    Route::get('/requests/create', [RequisitionerController::class, 'create'])->name('user.requests.create');
    Route::post('/requests', [RequisitionerController::class, 'store'])->name('user.requests.store');

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

        // Requisition Management Routes
        Route::get('/admin/requests', [RequisitionManagementController::class, 'index'])->name('admin.requests.index');
        Route::get('/admin/requests/{request}', [RequisitionManagementController::class, 'show'])->name('admin.requests.show');
        Route::put('/admin/requests/{assetRequest}', [RequisitionManagementController::class, 'update'])->name('admin.requests.update');

        // 3. Procurement Management Routes (ProcurementController)
Route::get('/admin/procurement', [ProcurementController::class, 'index'])->name('admin.procurement.index');
// FIX: Changed parameter name from {purchaseOrder} to {report} to match the model InspectionReport
Route::post('/admin/procurement/{report}/accept', [ProcurementController::class, 'acceptStock'])->name('admin.procurement.acceptStock'); 
Route::post('/admin/procurement/{report}/dispose', [ProcurementController::class, 'disposeCancel'])->name('admin.procurement.disposeCancel');
    
    });

    // 👀 Viewer pages
    Route::middleware('role:viewer')->group(function () {
        Route::view('/viewer/report', 'viewer.report')->name('viewer.report');

         // FIX: Update from static view to controller method
    Route::get('/viewer/report', [SupplyHeadController::class, 'overallReport'])->name('viewer.report');
    });
});