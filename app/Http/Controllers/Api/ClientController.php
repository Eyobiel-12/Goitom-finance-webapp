<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $organizationId = $request->user()->organization_id;
        
        $clients = Client::forOrganization($organizationId)
            ->when($request->get('search'), function ($query, $search) {
                return $query->search($search);
            })
            ->withCount(['projects', 'invoices'])
            ->orderBy('name')
            ->paginate($request->get('per_page', 15));

        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|array',
            'address.street' => 'nullable|string|max:255',
            'address.city' => 'nullable|string|max:255',
            'address.postal_code' => 'nullable|string|max:255',
            'address.country' => 'nullable|string|max:2',
            'tax_id' => 'nullable|string|max:255',
        ]);

        $validated['organization_id'] = $request->user()->organization_id;
        
        $client = Client::create($validated);

        return response()->json($client, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Client $client): JsonResponse
    {
        $this->authorize('view', $client);
        
        return response()->json($client->load(['projects', 'invoices']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client): JsonResponse
    {
        $this->authorize('update', $client);
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|array',
            'address.street' => 'nullable|string|max:255',
            'address.city' => 'nullable|string|max:255',
            'address.postal_code' => 'nullable|string|max:255',
            'address.country' => 'nullable|string|max:2',
            'tax_id' => 'nullable|string|max:255',
        ]);

        $client->update($validated);

        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Client $client): Response
    {
        $this->authorize('delete', $client);
        
        $client->delete();

        return response()->noContent();
    }

    /**
     * Get invoices for client
     */
    public function invoices(Request $request, Client $client): JsonResponse
    {
        $this->authorize('view', $client);
        
        $invoices = $client->invoices()
            ->with(['project', 'items'])
            ->when($request->get('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($invoices);
    }

    /**
     * Get projects for client
     */
    public function projects(Request $request, Client $client): JsonResponse
    {
        $this->authorize('view', $client);
        
        $projects = $client->projects()
            ->when($request->get('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($projects);
    }
}
