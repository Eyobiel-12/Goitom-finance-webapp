<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API routes protected by Sanctum authentication
Route::middleware(['auth:sanctum', 'org.access'])->prefix('v1')->group(function () {
    
    // Organization routes (admin only)
    Route::middleware('admin')->group(function () {
        Route::apiResource('organizations', OrganizationController::class);
        Route::get('organizations/{organization}/stats', [OrganizationController::class, 'stats']);
    });
    
    // Client routes
    Route::apiResource('clients', ClientController::class);
    Route::get('clients/{client}/invoices', [ClientController::class, 'invoices']);
    Route::get('clients/{client}/projects', [ClientController::class, 'projects']);
    
    // Project routes
    Route::apiResource('projects', ProjectController::class);
    Route::get('projects/{project}/invoices', [ProjectController::class, 'invoices']);
    Route::get('projects/{project}/time-tracking', [ProjectController::class, 'timeTracking']);
    
    // Invoice routes
    Route::apiResource('invoices', InvoiceController::class);
    Route::post('invoices/{invoice}/send', [InvoiceController::class, 'send']);
    Route::post('invoices/{invoice}/mark-paid', [InvoiceController::class, 'markPaid']);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf']);
    Route::get('invoices/{invoice}/payments', [InvoiceController::class, 'payments']);
    Route::post('invoices/{invoice}/payments', [InvoiceController::class, 'addPayment']);
    
    // Dashboard stats
    Route::get('dashboard/stats', function (Request $request) {
        $organizationId = $request->user()->organization_id;
        
        return response()->json([
            'total_clients' => \App\Models\Client::forOrganization($organizationId)->count(),
            'active_projects' => \App\Models\Project::forOrganization($organizationId)->where('status', 'active')->count(),
            'total_invoices' => \App\Models\Invoice::forOrganization($organizationId)->count(),
            'pending_invoices' => \App\Models\Invoice::forOrganization($organizationId)->where('status', 'sent')->count(),
            'overdue_invoices' => \App\Models\Invoice::forOrganization($organizationId)->overdue()->count(),
            'total_revenue' => \App\Models\Invoice::forOrganization($organizationId)->where('status', 'paid')->sum('total'),
        ]);
    });
    
    // Reports
    Route::get('reports/vat', function (Request $request) {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());
        $organizationId = $request->user()->organization_id;
        
        $invoices = \App\Models\Invoice::forOrganization($organizationId)
            ->whereBetween('issue_date', [$startDate, $endDate])
            ->get();
            
        return response()->json([
            'period' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'taxable_base' => $invoices->sum('subtotal'),
            'vat_collected' => $invoices->sum('vat_total'),
            'total_revenue' => $invoices->sum('total'),
            'invoice_count' => $invoices->count(),
        ]);
    });
});
