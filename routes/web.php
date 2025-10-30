<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Livewire\RegisterMultiStep;
use Illuminate\Support\Facades\Route;

// Lightweight health endpoint for container healthchecks
Route::get('/health', function () {
    return response('ok', 200);
});

Route::get('/', function () {
    return view('welcome');
});

// Publieke auth routes (zonder Breeze controllers)
Route::view('/login', 'auth.login')->name('login');
Route::get('/register', RegisterMultiStep::class)->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::view('/reset-password', 'auth.reset-password')->name('password.reset');

// Login submit (simple auth zonder Breeze controllers)
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ]);

    $remember = (bool) $request->boolean('remember');
    if (\Illuminate\Support\Facades\Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        return redirect()->intended(route('app.dashboard'));
    }

    return back()->withErrors([
        'email' => 'Ongeldige inloggegevens.',
    ])->onlyInput('email');
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
    Route::get('/clients/export', [ClientController::class, 'export'])->name('clients.export');
    Route::post('/clients/import', [ClientController::class, 'import'])->name('clients.import');
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
    Route::get('/invoices/export', [InvoiceController::class, 'export'])->name('invoices.export');
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
    // GET handler - redirect to invoice page (prevent MethodNotAllowed error)
    Route::get('/invoices/{invoice}/reminder', function ($invoice) {
        return redirect()->route('app.invoices.show', $invoice);
    });
    
    Route::post('/invoices/{invoice}/reminder', function ($invoice) {
        $invoice = \App\Models\Invoice::with(['client', 'organization', 'organization.owner', 'items'])->findOrFail($invoice);
        
        if ($invoice->status === 'paid') {
            return redirect()->route('app.invoices.show', $invoice)->with('error', 'Deze factuur is al betaald.');
        }
        
        if (!$invoice->client->email) {
            return redirect()->route('app.invoices.show', $invoice)->with('error', 'Klant heeft geen e-mailadres.');
        }
        
        try {
            // Generate PDF if not exists
            if (!$invoice->pdf_path) {
                $invoiceService = app(\App\Services\InvoiceService::class);
                $pdf = $invoiceService->generatePdfSync($invoice);
                // Reload to get updated pdf_path
                $invoice = $invoice->fresh(['client', 'organization', 'organization.owner', 'items']);
            }

            // Verstuur via Hostinger SMTP (geen Resend)
            \Illuminate\Support\Facades\Mail::to($invoice->client->email)
                ->bcc(config('mail.from.address'))
                ->send(new \App\Mail\InvoiceReminderMail($invoice, withAttachment: false));

            \Illuminate\Support\Facades\Log::info("Reminder email sent (Resend/SMTP) for invoice {$invoice->number} to {$invoice->client->email}", [
                'invoice_id' => $invoice->id,
                'client_email' => $invoice->client->email,
            ]);

            return redirect()->route('app.invoices.show', $invoice)->with('success', 'Herinneringsmail verzonden!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error sending reminder email (Resend/SMTP)", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'invoice_id' => $invoice->id,
                'client_email' => $invoice->client->email,
            ]);
            return redirect()->route('app.invoices.show', $invoice)->with('error', 'Fout bij verzenden herinneringsmail: ' . $e->getMessage());
        }
    })->name('invoices.reminder');
    
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
    
    
    
    // BTW Management
    Route::get('/btw', function () {
        return view('app.btw.index');
    })->name('btw.index');
    
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
});

// Legacy dashboard route for Breeze compatibility
Route::get('/dashboard', function () {
    return redirect()->route('app.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Explicit logout route to support Blade forms using route('logout')
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});

// Disabled Breeze auth routes include to avoid missing controller errors during build
// require __DIR__.'/auth.php';
