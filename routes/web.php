<?php

use App\Http\Controllers\BrandingSettingsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['web'])->group(function () {
    Route::get('/branding', [BrandingSettingsController::class, 'edit'])->name('branding.edit');
    Route::post('/branding', [BrandingSettingsController::class, 'update'])->name('branding.update');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::post('/invoices/{invoice}/duplicate', [InvoiceController::class, 'duplicate'])->name('invoices.duplicate');
    Route::post('/quotes/{quote}/convert', [InvoiceController::class, 'convertQuote'])->name('quotes.convert');

    Route::get('/portal', [PortalController::class, 'dashboard'])->name('portal.dashboard');
    Route::get('/portal/invoices/{invoice}', [PortalController::class, 'showInvoice'])->name('portal.invoices.show');
    Route::get('/portal/quotes/{quote}', [PortalController::class, 'showQuote'])->name('portal.quotes.show');
    Route::post('/portal/quotes/{quote}/accept', [PortalController::class, 'acceptQuote'])->name('portal.quotes.accept');
    Route::post('/portal/quotes/{quote}/reject', [PortalController::class, 'rejectQuote'])->name('portal.quotes.reject');
});

Route::get('/pay/{token}', [InvoiceController::class, 'payLink'])->name('invoices.pay');
