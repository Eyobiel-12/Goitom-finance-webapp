<?php

use App\Http\Controllers\ProfileController;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// App routes - protected by organization access
Route::middleware(['auth', 'verified', 'org.access'])->prefix('app')->name('app.')->group(function () {
    Route::get('/', function () {
        return view('app.dashboard');
    })->name('dashboard');
    
    Route::get('/clients', function () {
        return view('app.clients.index');
    })->name('clients.index');
    
    Route::get('/clients/create', function () {
        return view('app.clients.create');
    })->name('clients.create');
    
    Route::get('/clients/{client}/edit', function (Client $client) {
        return view('app.clients.edit', compact('client'));
    })->name('clients.edit');
    
    Route::get('/projects', function () {
        return view('app.projects.index');
    })->name('projects.index');
    
    Route::get('/projects/create', function () {
        return view('app.projects.create');
    })->name('projects.create');
    
    Route::get('/projects/{project}/edit', function (Project $project) {
        return view('app.projects.edit', compact('project'));
    })->name('projects.edit');
    
    Route::get('/invoices', function () {
        return view('app.invoices.index');
    })->name('invoices.index');
    
    Route::get('/invoices/create', function () {
        return view('app.invoices.create');
    })->name('invoices.create');
    
    Route::get('/invoices/{invoice}', function (Invoice $invoice) {
        return view('app.invoices.show', compact('invoice'));
    })->name('invoices.show');
    
    Route::get('/invoices/{invoice}/edit', function (Invoice $invoice) {
        return view('app.invoices.edit', compact('invoice'));
    })->name('invoices.edit');
    
    Route::get('/invoices/{invoice}/pdf', function (Invoice $invoice) {
        if (!$invoice->pdf_path) {
            abort(404, 'PDF niet gevonden');
        }
        
        return response()->file(storage_path('app/public/' . $invoice->pdf_path));
    })->name('invoices.pdf');
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
