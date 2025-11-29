<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(): Response
    {
        $blogs = Blog::query()
            ->orderByDesc('date')
            ->orderBy('sort_order')
            ->paginate(15);

        return Inertia::render('cms/blogs/Index', [
            'blogs' => $blogs,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('cms/blogs/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'short_description' => 'nullable|string',
            'main_image' => 'nullable|string',
            'date' => 'nullable|date',
            'author' => 'nullable|string|max:255',
            'author_url' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags_url' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|array',
            'related_posts' => 'nullable|array',
            'gallery' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Asegurar que is_active sea un booleano
        $validated['is_active'] = filter_var($request->input('is_active', true), FILTER_VALIDATE_BOOLEAN);

        Blog::create($validated);

        return redirect()->route('cms.blogs.index')
            ->with('success', 'Blog creado correctamente.');
    }

    public function edit(Blog $blog): Response
    {
        return Inertia::render('cms/blogs/Edit', [
            'blog' => $blog,
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'short_description' => 'nullable|string',
            'main_image' => 'nullable|string',
            'date' => 'nullable|date',
            'author' => 'nullable|string|max:255',
            'author_url' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags_url' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|array',
            'related_posts' => 'nullable|array',
            'gallery' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Asegurar que is_active sea un booleano
        if ($request->has('is_active')) {
            $validated['is_active'] = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);
        }

        $blog->update($validated);

        return redirect()->route('cms.blogs.index')
            ->with('success', 'Blog actualizado correctamente.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('cms.blogs.index')
            ->with('success', 'Blog eliminado correctamente.');
    }
}

