<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use App\Models\FeaturesAreaContent;
use App\Models\WorkingSchedule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FeaturesAreaController extends Controller
{
    public function index(): Response
    {
        $featuresArea = FeaturesAreaContent::first();
        
        if (!$featuresArea) {
            $featuresArea = FeaturesAreaContent::create([
                'working_hours_title' => 'Horario',
                'subtitle' => 'Contacto',
                'title' => 'Información de Contacto',
            ]);
        }

        return Inertia::render('cms/about/FeaturesArea/Index', [
            'featuresArea' => $featuresArea->load(['schedules', 'contactInfo']),
        ]);
    }

    public function update(Request $request)
    {
        $featuresArea = FeaturesAreaContent::first();
        
        if (!$featuresArea) {
            $featuresArea = FeaturesAreaContent::create([]);
        }

        $validated = $request->validate([
            'working_hours_background' => 'nullable|string',
            'working_hours_title' => 'nullable|string|max:255',
            'working_hours_description' => 'nullable|string|max:255',
            'is_open_now' => 'sometimes|boolean',
            'subtitle' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'slogan' => 'nullable|string|max:255',
        ]);

        if ($request->has('is_open_now')) {
            $validated['is_open_now'] = filter_var($request->input('is_open_now'), FILTER_VALIDATE_BOOLEAN);
        }

        $featuresArea->update($validated);

        return redirect()->route('cms.features-area.index')
            ->with('success', 'Contenido actualizado correctamente.');
    }

    public function storeSchedule(Request $request)
    {
        $featuresArea = FeaturesAreaContent::first();
        
        if (!$featuresArea) {
            $featuresArea = FeaturesAreaContent::create([]);
        }

        $validated = $request->validate([
            'day' => 'required|string|max:20',
            'hours' => 'required|string|max:100',
            'is_holiday' => 'sometimes|boolean',
            'display_order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['features_area_content_id'] = $featuresArea->id;
        $validated['display_order'] = $validated['display_order'] ?? 0;
        
        if ($request->has('is_holiday')) {
            $validated['is_holiday'] = filter_var($request->input('is_holiday'), FILTER_VALIDATE_BOOLEAN);
        }
        
        if ($request->has('is_active')) {
            $validated['is_active'] = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);
        }

        WorkingSchedule::create($validated);

        return redirect()->route('cms.features-area.index')
            ->with('success', 'Horario agregado correctamente.');
    }

    public function updateSchedule(Request $request, WorkingSchedule $schedule)
    {
        $validated = $request->validate([
            'day' => 'required|string|max:20',
            'hours' => 'required|string|max:100',
            'is_holiday' => 'sometimes|boolean',
            'display_order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->has('is_holiday')) {
            $validated['is_holiday'] = filter_var($request->input('is_holiday'), FILTER_VALIDATE_BOOLEAN);
        }
        
        if ($request->has('is_active')) {
            $validated['is_active'] = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);
        }

        $schedule->update($validated);

        return redirect()->route('cms.features-area.index')
            ->with('success', 'Horario actualizado correctamente.');
    }

    public function destroySchedule(WorkingSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('cms.features-area.index')
            ->with('success', 'Horario eliminado correctamente.');
    }

    public function storeContactInfo(Request $request)
    {
        $featuresArea = FeaturesAreaContent::first();
        
        if (!$featuresArea) {
            $featuresArea = FeaturesAreaContent::create([]);
        }

        $validated = $request->validate([
            'icon_class' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'link' => 'nullable|string|max:500',
            'is_external' => 'sometimes|boolean',
            'display_order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['features_area_content_id'] = $featuresArea->id;
        $validated['display_order'] = $validated['display_order'] ?? 0;
        
        if ($request->has('is_external')) {
            $validated['is_external'] = filter_var($request->input('is_external'), FILTER_VALIDATE_BOOLEAN);
        }
        
        if ($request->has('is_active')) {
            $validated['is_active'] = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);
        }

        ContactInfo::create($validated);

        return redirect()->route('cms.features-area.index')
            ->with('success', 'Información de contacto agregada correctamente.');
    }

    public function updateContactInfo(Request $request, ContactInfo $contactInfo)
    {
        $validated = $request->validate([
            'icon_class' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'link' => 'nullable|string|max:500',
            'is_external' => 'sometimes|boolean',
            'display_order' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->has('is_external')) {
            $validated['is_external'] = filter_var($request->input('is_external'), FILTER_VALIDATE_BOOLEAN);
        }
        
        if ($request->has('is_active')) {
            $validated['is_active'] = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);
        }

        $contactInfo->update($validated);

        return redirect()->route('cms.features-area.index')
            ->with('success', 'Información de contacto actualizada correctamente.');
    }

    public function destroyContactInfo(ContactInfo $contactInfo)
    {
        $contactInfo->delete();

        return redirect()->route('cms.features-area.index')
            ->with('success', 'Información de contacto eliminada correctamente.');
    }
}

