<?php

use App\Http\Controllers\BtwController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Lightweight health endpoint for container healthchecks
Route::get('/health', function () {
    return response('ok', 200);
});

Route::get('/', function () {
    return view('welcome');
});

// Unsubscribe route (for email deliverability)
Route::get('/unsubscribe', function () {
    return view('emails.unsubscribe');
})->name('mail.unsubscribe');

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
    
    Route::post('/pdf-settings/upload-logo', function (\Illuminate\Http\Request $request) {
        // Zorg dat ALLES als JSON wordt geretourneerd, ook errors
        // Start output buffering om alle PHP errors/notices te vangen
        ob_start();
        
        try {
            // Check of gebruiker is ingelogd
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Niet ingelogd'
                ], 401)->header('Content-Type', 'application/json');
            }
            
            // Validate logo
            try {
                $request->validate([
                    'logo' => 'required|image|max:2048',
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validatie mislukt: ' . implode(', ', $e->errors()['logo'] ?? ['Ongeldig bestand'])
                ], 422)->header('Content-Type', 'application/json');
            }
            
            // Check of bestand bestaat
            if (!$request->hasFile('logo')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Geen logo bestand ontvangen'
                ], 400)->header('Content-Type', 'application/json');
            }
            
            $organization = auth()->user()->organization;
            
            if (!$organization) {
                return response()->json([
                    'success' => false,
                    'message' => 'Organization niet gevonden'
                ], 404)->header('Content-Type', 'application/json');
            }
            
            // Verwijder oude logo als die bestaat
            if ($organization->logo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($organization->logo_path)) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($organization->logo_path);
                } catch (\Exception $e) {
                    // Ignore delete errors
                }
            }
            
            // Upload nieuw logo
            $path = $request->file('logo')->store('logos', 'public');
            
            // Verifieer dat bestand bestaat
            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Logo upload mislukt. Bestand niet gevonden na upload.'
                ], 500)->header('Content-Type', 'application/json');
            }
            
            // Update organization met logo_path
            $organization->logo_path = $path;
            $organization->save();
            
            // Clean output buffer voordat we response sturen
            ob_clean();
            
            return response()->json([
                'success' => true,
                'message' => 'Logo succesvol geüpload!',
                'logo_path' => $path
            ], 200)->header('Content-Type', 'application/json');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            ob_clean();
            return response()->json([
                'success' => false,
                'message' => 'Validatie mislukt: ' . implode(', ', $e->errors()['logo'] ?? ['Ongeldig bestand'])
            ], 422)->header('Content-Type', 'application/json');
        } catch (\Throwable $e) {
            // Clean output buffer
            ob_clean();
            
            \Log::error('Logo upload error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Logo upload mislukt: ' . $e->getMessage()
            ], 500)->header('Content-Type', 'application/json');
        } finally {
            // Clean up output buffer
            ob_end_clean();
        }
    })->name('pdf-settings.upload-logo');
    
    // BTW Management
    Route::get('/btw', [\App\Http\Controllers\BtwController::class, 'index'])->name('btw.index');
    
    // BTW Aftrek routes
    Route::get('/btw/aftrek', function () {
        return view('app.btw-aftrek.index');
    })->name('btw-aftrek.index');
    Route::get('/btw/aftrek/create', function () {
        return view('app.btw-aftrek.create');
    })->name('btw-aftrek.create');
    
    // BTW Aangifte routes
    Route::get('/btw/aangifte', function () {
        return view('app.btw-aangifte.index');
    })->name('btw-aangifte.index');
    
    // Subscription routes
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('/subscription/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/subscription/callback', [SubscriptionController::class, 'callback'])->name('subscription.callback');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::get('/subscription/payment/{payment}/download', [SubscriptionController::class, 'downloadPayment'])->name('subscription.payment.download');
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
