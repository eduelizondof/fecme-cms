<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Breeder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BreederController extends Controller
{
    public function index(): Response
    {
        $breeders = Breeder::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return Inertia::render('cms/breeders/Index', [
            'breeders' => $breeders,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('cms/breeders/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:breeders,slug',
            'logo' => 'nullable|string',
            'feature_image' => 'nullable|string',
            'breeds' => 'nullable|array',
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
            'sires' => 'nullable|array',
            'care' => 'nullable|array',
            'awards' => 'nullable|array',
            'gallery' => 'nullable|array',
            'reviews' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        Breeder::create($validated);

        return redirect()->route('cms.breeders.index')
            ->with('success', 'Criadero creado correctamente.');
    }

    public function edit(Breeder $breeder): Response
    {
        return Inertia::render('cms/breeders/Edit', [
            'breeder' => $breeder,
        ]);
    }

    public function update(Request $request, Breeder $breeder)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:breeders,slug,' . $breeder->id,
            'logo' => 'nullable|string',
            'feature_image' => 'nullable|string',
            'breeds' => 'nullable|array',
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
            'sires' => 'nullable|array',
            'care' => 'nullable|array',
            'awards' => 'nullable|array',
            'gallery' => 'nullable|array',
            'reviews' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $breeder->update($validated);

        return redirect()->route('cms.breeders.index')
            ->with('success', 'Criadero actualizado correctamente.');
    }

    public function destroy(Breeder $breeder)
    {
        $breeder->delete();

        return redirect()->route('cms.breeders.index')
            ->with('success', 'Criadero eliminado correctamente.');
    }
}

