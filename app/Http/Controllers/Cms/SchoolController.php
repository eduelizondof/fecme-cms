<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SchoolController extends Controller
{
    public function index(): Response
    {
        $schools = School::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return Inertia::render('cms/schools/Index', [
            'schools' => $schools,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('cms/schools/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:schools,slug',
            'logo' => 'nullable|string',
            'feature_image' => 'nullable|string',
            'programs_list' => 'nullable|array',
            'location' => 'nullable|array',
            'member_since' => 'nullable|string|max:10',
            'rating' => 'nullable|numeric|min:0|max:5',
            'total_reviews' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'social_links' => 'nullable|array',
            'certifications' => 'nullable|array',
            'features' => 'nullable|array',
            'responsible' => 'nullable|array',
            'about' => 'nullable|array',
            'programs' => 'nullable|array',
            'facilities' => 'nullable|array',
            'awards' => 'nullable|array',
            'gallery' => 'nullable|array',
            'reviews' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        School::create($validated);

        return redirect()->route('cms.schools.index')
            ->with('success', 'Escuela creada correctamente.');
    }

    public function edit(School $school): Response
    {
        return Inertia::render('cms/schools/Edit', [
            'school' => $school,
        ]);
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:schools,slug,' . $school->id,
            'logo' => 'nullable|string',
            'feature_image' => 'nullable|string',
            'programs_list' => 'nullable|array',
            'location' => 'nullable|array',
            'member_since' => 'nullable|string|max:10',
            'rating' => 'nullable|numeric|min:0|max:5',
            'total_reviews' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'social_links' => 'nullable|array',
            'certifications' => 'nullable|array',
            'features' => 'nullable|array',
            'responsible' => 'nullable|array',
            'about' => 'nullable|array',
            'programs' => 'nullable|array',
            'facilities' => 'nullable|array',
            'awards' => 'nullable|array',
            'gallery' => 'nullable|array',
            'reviews' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $school->update($validated);

        return redirect()->route('cms.schools.index')
            ->with('success', 'Escuela actualizada correctamente.');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('cms.schools.index')
            ->with('success', 'Escuela eliminada correctamente.');
    }
}

