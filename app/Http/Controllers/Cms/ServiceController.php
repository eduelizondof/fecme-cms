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
            'show_in_services' => 'sometimes|boolean',
            'show_in_pricing' => 'sometimes|boolean',
            'pricing_category' => 'nullable|string|max:100',
            'pricing_features' => 'nullable|array',
            'description' => 'nullable|string',
            'featured' => 'nullable|array',
            'gallery' => 'nullable|array',
            'requirements' => 'nullable|array',
            'cost' => 'nullable|array',
            'formats' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Asegurar que los valores booleanos sean correctos
        $validated['show_in_services'] = filter_var($request->input('show_in_services', true), FILTER_VALIDATE_BOOLEAN);
        $validated['show_in_pricing'] = filter_var($request->input('show_in_pricing', false), FILTER_VALIDATE_BOOLEAN);
        $validated['is_active'] = filter_var($request->input('is_active', true), FILTER_VALIDATE_BOOLEAN);

        Service::create($validated);

        return redirect()->route('cms.services.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Service $service): Response
    {
        // Recargar el modelo para asegurar que los casts se apliquen
        $service->refresh();
        
        // Usar los atributos del modelo que ya aplican los casts automáticamente
        // Los casts del modelo convierten automáticamente los valores
        $serviceData = [
            'id' => $service->id,
            'slug' => $service->slug,
            'title' => $service->title,
            'type' => $service->type,
            'short_description' => $service->short_description,
            'main_image' => $service->main_image,
            'image' => $service->image,
            // Los casts del modelo ya convierten a boolean, pero aseguramos con (bool)
            'show_in_services' => (bool) $service->show_in_services,
            'show_in_pricing' => (bool) $service->show_in_pricing,
            'pricing_category' => $service->pricing_category,
            // Los casts del modelo ya convierten JSON a array
            'pricing_features' => $service->pricing_features ?? [],
            'description' => $service->description,
            'featured' => $service->featured,
            'gallery' => $service->gallery ?? [],
            'requirements' => $service->requirements ?? [],
            'cost' => $service->cost,
            'formats' => $service->formats,
            'is_active' => (bool) $service->is_active,
            'sort_order' => $service->sort_order,
        ];

        // Log para debug
        \Log::info('ServiceController@edit - Valores del servicio:', [
            'raw_show_in_services' => $service->getRawOriginal('show_in_services'),
            'cast_show_in_services' => $service->show_in_services,
            'final_show_in_services' => $serviceData['show_in_services'],
            'raw_show_in_pricing' => $service->getRawOriginal('show_in_pricing'),
            'cast_show_in_pricing' => $service->show_in_pricing,
            'final_show_in_pricing' => $serviceData['show_in_pricing'],
            'raw_is_active' => $service->getRawOriginal('is_active'),
            'cast_is_active' => $service->is_active,
            'final_is_active' => $serviceData['is_active'],
            'types' => [
                'show_in_services' => gettype($serviceData['show_in_services']),
                'show_in_pricing' => gettype($serviceData['show_in_pricing']),
                'is_active' => gettype($serviceData['is_active']),
            ],
        ]);

        return Inertia::render('cms/services/Edit', [
            'service' => $serviceData,
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
            'show_in_services' => 'sometimes|boolean',
            'show_in_pricing' => 'sometimes|boolean',
            'pricing_category' => 'nullable|string|max:100',
            'pricing_features' => 'nullable|array',
            'description' => 'nullable|string',
            'featured' => 'nullable|array',
            'gallery' => 'nullable|array',
            'requirements' => 'nullable|array',
            'cost' => 'nullable|array',
            'formats' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Asegurar que los valores booleanos sean correctos
        $validated['show_in_services'] = filter_var($request->input('show_in_services', $service->show_in_services), FILTER_VALIDATE_BOOLEAN);
        $validated['show_in_pricing'] = filter_var($request->input('show_in_pricing', $service->show_in_pricing), FILTER_VALIDATE_BOOLEAN);
        $validated['is_active'] = filter_var($request->input('is_active', $service->is_active), FILTER_VALIDATE_BOOLEAN);

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

