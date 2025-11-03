<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $query = Client::forOrganization(auth()->user()->organization_id)
            ->withCount(['projects', 'invoices']);
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $clients = $query->latest()->paginate(12)->withQueryString();

        return view('app.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('app.clients.create');
    }

    public function store(ClientRequest $request): RedirectResponse
    {
        $client = Client::create([
            'organization_id' => auth()->user()->organization_id,
            ...$request->validated(),
        ]);

        return redirect()->route('app.clients.index')
            ->with('success', 'Klant toegevoegd.');
    }

    public function show(Client $client): View
    {
        $client->load(['projects', 'invoices', 'invoices.items']);
        
        return view('app.clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        return view('app.clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()->route('app.clients.index')
            ->with('success', 'Klant bijgewerkt.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('app.clients.index')
            ->with('success', 'Klant verwijderd.');
    }
}
