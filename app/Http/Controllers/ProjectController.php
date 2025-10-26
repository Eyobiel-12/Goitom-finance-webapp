<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::forOrganization(auth()->user()->organization_id)
            ->with(['client'])
            ->latest()
            ->paginate(12);

        return view('app.projects.index', compact('projects'));
    }

    public function create(): View
    {
        $clients = Client::forOrganization(auth()->user()->organization_id)
            ->orderBy('name')
            ->get();

        return view('app.projects.create', compact('clients'));
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = Project::create([
            'organization_id' => auth()->user()->organization_id,
            ...$request->validated(),
        ]);

        return redirect()->route('app.projects.index')
            ->with('success', 'Project toegevoegd.');
    }

    public function show(Project $project): View
    {
        $project->load(['client', 'invoices', 'invoices.items']);
        
        return view('app.projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $clients = Client::forOrganization(auth()->user()->organization_id)
            ->orderBy('name')
            ->get();

        return view('app.projects.edit', compact('project', 'clients'));
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        return redirect()->route('app.projects.index')
            ->with('success', 'Project bijgewerkt.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('app.projects.index')
            ->with('success', 'Project verwijderd.');
    }
}
