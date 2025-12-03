<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Default Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authenticated + Verified Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Product Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::put('/{product}/update', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Category Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Unit Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('unit')->name('unit.')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::get('/{unit}/edit', [UnitController::class, 'edit'])->name('edit');
        Route::post('/', [UnitController::class, 'store'])->name('store');
        Route::put('/{unit}/update', [UnitController::class, 'update'])->name('update');
        Route::delete('/{unit}', [UnitController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Invoice Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('invoice')->name('invoice.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('create');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');
        Route::get('/report', [InvoiceController::class, 'financialReport'])->name('report');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
        Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
        Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
        Route::get('/{invoice}/download', [InvoiceController::class, 'download'])->name('download');
        Route::post('/{invoice}/send', [InvoiceController::class, 'send'])->name('send');
        Route::get('/{invoice}/pay', [InvoiceController::class, 'pay'])->name('pay');
        Route::get('/{invoice}/callback', [InvoiceController::class, 'handleCallback'])->name('callback');
        Route::post('/{invoice}/mark-paid', [InvoiceController::class, 'markPaid'])->name('markPaid');
        Route::post('/{invoice}/mark-partial', [InvoiceController::class, 'markPartial'])->name('markPartial');
    });

    /*
    |--------------------------------------------------------------------------
    | Customer Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Paystack Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('paystack')->name('paystack.')->group(function () {
        Route::get('/connect', [PaystackController::class, 'showConnectForm'])->name('connect');
        Route::post('/connect', [PaystackController::class, 'saveKeys'])->name('save');
    });

    /*
    |--------------------------------------------------------------------------
    | Payment Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/callback/{invoice}', [PaymentController::class, 'handleCallback'])->name('callback');
        Route::post('/webhook', [PaymentController::class, 'handleWebhook'])->name('webhook');
    });

    /*
    |--------------------------------------------------------------------------
    | Branch Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('branch')->name('branch.')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('index');
        Route::get('/create', [BranchController::class, 'create'])->name('create');
        Route::get('/edit/{branch}', [BranchController::class, 'edit'])->name('edit');
        Route::get('/{branch}', [BranchController::class, 'show'])->name('show');
        Route::post('/', [BranchController::class, 'store'])->name('store');
        Route::put('/update/{branch}', [BranchController::class, 'update'])->name('update');
        Route::delete('/update/{branch}', [BranchController::class, 'destroy'])->name('destroy');
        Route::post('/{branch}/accountant', [BranchController::class, 'storeAccountant'])->name('accountant.store');
        Route::delete('/{branch}/accountant/{user}', [BranchController::class, 'destroyAccountant'])->name('accountant.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/paystack', [ProfileController::class, 'updatePaystackKeys'])->name('profile.updatePaystackKeys');
    Route::post('/profile/upload-logo', [ProfileController::class, 'uploadLogo'])->name('profile.uploadLogo');
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES FOR INVOICE PAYMENT
|--------------------------------------------------------------------------
*/
Route::get('/invoice/{invoice}/paid', [InvoiceController::class, 'paymentSuccess'])->name('invoice.paid');
Route::get('/invoice/{invoice}/receipt', [InvoiceController::class, 'receipt'])->name('invoice.show.receipt');
Route::get('/pay-invoice/{invoice}', [InvoiceController::class, 'publicPay'])->name('invoice.public.pay');
Route::get('/pay-invoice/{invoice}/callback', [InvoiceController::class, 'publicCallback'])->name('invoice.public.callback');
