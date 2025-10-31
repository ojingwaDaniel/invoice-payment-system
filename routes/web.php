<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\Dash;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;

use Illuminate\Http\Request;



require __DIR__ . '/auth.php';
Route::get("/", function () {
    return redirect()->route("login");
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Verify the user when they click the link
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/admin/dashboard')->with('verified', true);
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard',[DashboardController::class,"index"])->name('dashboard');

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
        Route::get("/{category}/edit", [CategoryController::class, "edit"])->name("edit");
        Route::put("/{category}/update", [CategoryController::class, "update"])->name("update");
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
        Route::get('/{invoice}/pay', [App\Http\Controllers\InvoiceController::class, 'pay'])->name('pay');
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

    Route::prefix("paystack")->name("paystack.")->group(function () {
        Route::get('/connect', [PaystackController::class, 'redirectToPaystack'])->name('connect');
        Route::get('/callback', [PaystackController::class, 'handlePaystackCallback'])->name('callback');
    });
    Route::prefix("payment")->name("payment.")->group(function () {
        Route::get('/callback/{invoice}', [PaymentController::class, 'handleCallback'])->name('callback');
        Route::post('/webhook', [PaymentController::class, 'handleWebhook'])->name('webhook');
    });

    Route::get('/api/products/{product}', [ProductApiController::class, 'show']);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
