<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\FaqItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    public function index(): Response
    {
        $faqs = FaqItem::query()
            ->orderBy('display_order')
            ->orderBy('id')
            ->get();

        return Inertia::render('cms/about/faq/Index', [
            'faqs' => $faqs,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('cms/about/faq/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'is_active' => 'sometimes|boolean',
            'display_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = filter_var($request->input('is_active', true), FILTER_VALIDATE_BOOLEAN);
        $validated['display_order'] = $validated['display_order'] ?? 0;

        FaqItem::create($validated);

        return redirect()->route('cms.faq.index')
            ->with('success', 'FAQ creada correctamente.');
    }

    public function edit(FaqItem $faq): Response
    {
        return Inertia::render('cms/about/faq/Edit', [
            'faq' => $faq,
        ]);
    }

    public function update(Request $request, FaqItem $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'is_active' => 'sometimes|boolean',
            'display_order' => 'nullable|integer',
        ]);

        // Asegurar que is_active sea un booleano, incluso si no viene en el request
        $validated['is_active'] = filter_var($request->input('is_active', false), FILTER_VALIDATE_BOOLEAN);

        $faq->update($validated);

        return redirect()->route('cms.faq.index')
            ->with('success', 'FAQ actualizada correctamente.');
    }

    public function destroy(FaqItem $faq)
    {
        $faq->delete();

        return redirect()->route('cms.faq.index')
            ->with('success', 'FAQ eliminada correctamente.');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:faq_items,id',
            'items.*.display_order' => 'required|integer',
        ]);

        foreach ($validated['items'] as $item) {
            FaqItem::where('id', $item['id'])->update(['display_order' => $item['display_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden actualizado correctamente.',
        ]);
    }
}

