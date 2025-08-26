<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PDFController;

/*
|--------------------------------------------------------------------------|
| Web Routes                                                               |
|--------------------------------------------------------------------------|
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [InvoiceController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Templates
    Route::get('/templates', function () {
        return view('templates');
    })->name('templates');

    // PDF
    Route::get('/invoice/pdf/{invoice_id}', [PDFController::class, 'generatePDF'])->name('invoice.pdf');

    // Invoice Routes
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/invoice/store', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoices/search', [InvoiceController::class, 'search'])->name('invoice.search');
    Route::get('/invoices/sent', [InvoiceController::class, 'sentInvoices'])->name('invoice.sent');
    Route::get('/invoices/received', [InvoiceController::class, 'receivedInvoices'])->name('invoice.received');
    Route::get('/invoices/paid', [InvoiceController::class, 'paidInvoices'])->name('invoice.paid');
    Route::get('/invoices/pending', [InvoiceController::class, 'pendingInvoices'])->name('invoice.pending');
    Route::get('/invoices/unpaid', [InvoiceController::class, 'unpaidInvoices'])->name('invoice.unpaid');
    Route::get('/invoice/{invoice_id}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/invoice/{invoice_id}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{invoice}', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('/invoice/{invoice_id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::post('/invoice/scan', [InvoiceController::class, 'scan'])->name('invoice.scan');

});

// Auth scaffolding routes (login, register, etc.)
require __DIR__.'/auth.php';
