<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Judge;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JudgeController extends Controller
{
    public function index(): Response
    {
        $judges = Judge::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return Inertia::render('cms/judges/Index', [
            'judges' => $judges,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('cms/judges/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'photo' => 'nullable|string',
            'license_type' => 'nullable|string|max:50',
            'categories' => 'nullable|array',
            'breeds' => 'nullable|array',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        Judge::create($validated);

        return redirect()->route('cms.judges.index')
            ->with('success', 'Juez creado correctamente.');
    }

    public function edit(Judge $judge): Response
    {
        return Inertia::render('cms/judges/Edit', [
            'judge' => $judge,
        ]);
    }

    public function update(Request $request, Judge $judge)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'photo' => 'nullable|string',
            'license_type' => 'nullable|string|max:50',
            'categories' => 'nullable|array',
            'breeds' => 'nullable|array',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $judge->update($validated);

        return redirect()->route('cms.judges.index')
            ->with('success', 'Juez actualizado correctamente.');
    }

    public function destroy(Judge $judge)
    {
        $judge->delete();

        return redirect()->route('cms.judges.index')
            ->with('success', 'Juez eliminado correctamente.');
    }
}



