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
        $clients = Client::forOrganization(auth()->user()->organization_id)
            ->withCount(['projects', 'invoices'])
            ->latest()
            ->paginate(12);

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
