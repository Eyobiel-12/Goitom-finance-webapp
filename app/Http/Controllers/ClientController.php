<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    public function export(Request $request): BinaryFileResponse
    {
        $format = $request->get('format', 'xlsx'); // xlsx, csv
        
        $fileName = 'klanten-export-' . now()->format('Y-m-d-His') . '.' . $format;
        
        return Excel::download(
            new ClientsExport(auth()->user()->organization_id),
            $fileName
        );
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(
                new ClientsImport(auth()->user()->organization_id),
                $request->file('file')
            );

            return redirect()->route('app.clients.index')
                ->with('success', 'Klanten succesvol geïmporteerd!');
        } catch (\Exception $e) {
            return redirect()->route('app.clients.index')
                ->with('error', 'Import mislukt: ' . $e->getMessage());
        }
    }
}
