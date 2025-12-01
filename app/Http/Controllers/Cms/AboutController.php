<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use App\Models\AboutFeature;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        $about = AboutContent::first();
        
        if (!$about) {
            $about = AboutContent::create([
                'subtitle' => 'Nosotros',
                'title' => '¿Quiénes Somos?',
                'experience_label' => '+e Razas',
            ]);
        }

        return Inertia::render('cms/about/About/Index', [
            'about' => $about->load('features'),
        ]);
    }

    public function update(Request $request)
    {
        $about = AboutContent::first();
        
        if (!$about) {
            $about = AboutContent::create([]);
        }

        $validated = $request->validate([
            'background_image' => 'nullable|string',
            'main_image' => 'nullable|string',
            'main_image_alt' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'experience_from' => 'nullable|integer',
            'experience_to' => 'nullable|integer',
            'experience_speed' => 'nullable|integer',
            'experience_initial_value' => 'nullable|integer',
            'experience_label' => 'nullable|string|max:255',
        ]);

        $about->update($validated);

        return redirect()->route('cms.about.index')
            ->with('success', 'Contenido actualizado correctamente.');
    }

    public function storeFeature(Request $request)
    {
        $about = AboutContent::first();
        
        if (!$about) {
            $about = AboutContent::create([]);
        }

        $validated = $request->validate([
            'icon' => 'required|string|max:100',
            'color' => 'required|in:red,green,orange,blues',
            'label' => 'required|string|max:255',
            'display_order' => 'nullable|integer',
        ]);

        $validated['about_content_id'] = $about->id;
        $validated['display_order'] = $validated['display_order'] ?? 0;

        AboutFeature::create($validated);

        return redirect()->route('cms.about.index')
            ->with('success', 'Característica agregada correctamente.');
    }

    public function updateFeature(Request $request, AboutFeature $feature)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:100',
            'color' => 'required|in:red,green,orange,blues',
            'label' => 'required|string|max:255',
            'display_order' => 'nullable|integer',
        ]);

        $feature->update($validated);

        return redirect()->route('cms.about.index')
            ->with('success', 'Característica actualizada correctamente.');
    }

    public function destroyFeature(AboutFeature $feature)
    {
        $feature->delete();

        return redirect()->route('cms.about.index')
            ->with('success', 'Característica eliminada correctamente.');
    }
}

