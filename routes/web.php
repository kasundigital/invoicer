<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandingSettingsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PortalAuthController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::middleware(['staff'])->group(function () {
        Route::get('/branding', [BrandingSettingsController::class, 'edit'])->name('branding.edit');
        Route::post('/branding', [BrandingSettingsController::class, 'update'])->name('branding.update');

        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::post('/invoices/{invoice}/duplicate', [InvoiceController::class, 'duplicate'])->name('invoices.duplicate');
        Route::post('/quotes/{quote}/convert', [InvoiceController::class, 'convertQuote'])->name('quotes.convert');
        Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
        Route::post('/invoices/{invoice}/send-email', [InvoiceController::class, 'sendEmail'])->name('invoices.send-email');

        Route::get('/reports/ar-aging', [ReportsController::class, 'aging'])->name('reports.aging');
        Route::get('/reports/sales-by-customer', [ReportsController::class, 'salesByCustomer'])->name('reports.sales-by-customer');
    });

    Route::get('/portal/login', [PortalAuthController::class, 'showLogin'])->name('portal.login');
    Route::post('/portal/login', [PortalAuthController::class, 'login'])->name('portal.login.submit');
    Route::post('/portal/logout', [PortalAuthController::class, 'logout'])->name('portal.logout');

    Route::middleware(['customer'])->group(function () {
        Route::get('/portal', [PortalController::class, 'dashboard'])->name('portal.dashboard');
        Route::get('/portal/invoices/{invoice}', [PortalController::class, 'showInvoice'])->name('portal.invoices.show');
        Route::get('/portal/quotes/{quote}', [PortalController::class, 'showQuote'])->name('portal.quotes.show');
        Route::post('/portal/quotes/{quote}/accept', [PortalController::class, 'acceptQuote'])->name('portal.quotes.accept');
        Route::post('/portal/quotes/{quote}/reject', [PortalController::class, 'rejectQuote'])->name('portal.quotes.reject');
    });
});

Route::get('/pay/{token}', [InvoiceController::class, 'payLink'])->name('invoices.pay');
Route::post('/pay/{token}/complete', [InvoiceController::class, 'completePayment'])->name('invoices.pay.complete');
