<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        $services = Service::query()
            ->orderBy('sort_order')
            ->paginate(15);

        return Inertia::render('cms/services/Index', [
            'services' => $services,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('cms/services/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'type' => 'nullable|string|max:100',
            'short_description' => 'nullable|string',
            'main_image' => 'nullable|string',
            'image' => 'nullable|string',
            'show_in_services' => 'boolean',
            'show_in_pricing' => 'boolean',
            'pricing_category' => 'nullable|string|max:100',
            'pricing_features' => 'nullable|array',
            'description' => 'nullable|string',
            'featured' => 'nullable|array',
            'gallery' => 'nullable|array',
            'requirements' => 'nullable|array',
            'cost' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        Service::create($validated);

        return redirect()->route('cms.services.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Service $service): Response
    {
        return Inertia::render('cms/services/Edit', [
            'service' => $service,
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $service->id,
            'type' => 'nullable|string|max:100',
            'short_description' => 'nullable|string',
            'main_image' => 'nullable|string',
            'image' => 'nullable|string',
            'show_in_services' => 'boolean',
            'show_in_pricing' => 'boolean',
            'pricing_category' => 'nullable|string|max:100',
            'pricing_features' => 'nullable|array',
            'description' => 'nullable|string',
            'featured' => 'nullable|array',
            'gallery' => 'nullable|array',
            'requirements' => 'nullable|array',
            'cost' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $service->update($validated);

        return redirect()->route('cms.services.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('cms.services.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}

