<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// App routes - protected by organization access
Route::middleware(['auth', 'verified', 'org.access'])->prefix('app')->name('app.')->group(function () {
    Route::get('/', function () {
        return view('app.dashboard');
    })->name('dashboard');
    
    // Clients routes
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    
    // Projects routes
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    
    // Invoices routes
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    Route::post('/invoices/{invoice}/send', function ($invoice) {
        $invoice = \App\Models\Invoice::findOrFail($invoice);
        $invoiceService = app(\App\Services\InvoiceService::class);
        $invoiceService->sendInvoice($invoice);
        return back()->with('success', 'Factuur verzonden!');
    })->name('invoices.send');
    Route::post('/invoices/{invoice}/mark-paid', function ($invoice) {
        $invoice = \App\Models\Invoice::findOrFail($invoice);
        $invoiceService = app(\App\Services\InvoiceService::class);
        $invoiceService->markAsPaid($invoice);
        return back()->with('success', 'Factuur gemarkeerd als betaald!');
    })->name('invoices.markPaid');
    
    // PDF route - Generate on the fly
    Route::get('/invoices/{invoice}/pdf', function ($invoice) {
        $invoice = \App\Models\Invoice::with(['client', 'organization', 'items'])->findOrFail($invoice);
        
        // Always generate fresh PDF with current template
        // Determine which template to use
        $template = $invoice->organization->settings['pdf_template'] ?? 'classic';
        $viewName = "invoices.pdf-{$template}";
        
        // Generate PDF on the fly using DomPDF
        $pdf = \PDF::loadView($viewName, compact('invoice'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-local-file-access', true);
        
        return $pdf->download('factuur-' . $invoice->number . '.pdf');
    })->name('invoices.pdf');
    
    // PDF Settings
    Route::get('/pdf-settings', function () {
        return view('app.pdf-settings');
    })->name('pdf-settings');
});

// Legacy dashboard route for Breeze compatibility
Route::get('/dashboard', function () {
    return redirect()->route('app.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
