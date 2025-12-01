<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class MediaController extends Controller
{
    public function index(Request $request): Response|JsonResponse
    {
        $query = Media::query()
            ->orderByDesc('created_at');

        if ($request->has('type') && $request->type === 'images') {
            $query->images();
        }

        $media = $query->paginate($request->get('per_page', 24));

        if ($request->wantsJson()) {
            return response()->json($media);
        }

        return Inertia::render('cms/media/Index', [
            'media' => $media,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads/' . date('Y/m'), $fileName, 'public');

        $media = Media::create([
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'path' => $path,
            'disk' => 'public',
            'size' => $file->getSize(),
            'alt_text' => $request->alt_text,
            'title' => $request->title,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'media' => $media,
            'url' => $media->url,
        ]);
    }

    public function destroy(Media $media): JsonResponse
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Archivo eliminado correctamente.',
        ]);
    }

    public function update(Request $request, Media $media): JsonResponse
    {
        $validated = $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $media->update($validated);

        return response()->json([
            'success' => true,
            'media' => $media,
        ]);
    }
}


