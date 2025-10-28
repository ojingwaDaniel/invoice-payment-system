<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Public routes (home + auth scaffolding) and a middleware-protected
| group for the application (auth + verified).
|
*/

// Redirect root to dashboard (guest can be redirected to login by middleware)
Route::get('/', function () {
    return redirect()->route('dashboard');
});


require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    // Product routes
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::put('/{product}/update', [ProductController::class, 'update'])->name('update');
    });

    //  Category Routes
    Route::prefix("category")->name("category.")->group(function () {
        Route::get("/", [CategoryController::class, "index"])->name("index");
        Route::get("/create", [CategoryController::class, "create"])->name("create");
        Route::post("/", [CategoryController::class, "store"])->name("store");
        Route::put("/{category}/edit", [CategoryController::class, "edit"])->name("edit");
        Route::post("/{category}", [CategoryController::class, "destroy"])->name("destroy");
    });
    // unit Routes
    Route::prefix("unit")->name("unit.")->group(function () {
        Route::get("/", [UnitController::class, "index"])->name("index");
    });
    // Invoice routes
    Route::prefix('invoice')->name('invoice.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('create');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');

        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
        Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
        Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
        Route::get('/{invoice}/download', [InvoiceController::class, 'download'])->name('download');
        Route::post('/{invoice}/send', [InvoiceController::class, 'send'])->name('send');
    });

    // Customer routes
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    Route::get('/api/products/{product}', [ProductApiController::class, 'show']);
});
