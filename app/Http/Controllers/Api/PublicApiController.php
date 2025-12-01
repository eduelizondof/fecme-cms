<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Breeder;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Judge;
use App\Models\School;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicApiController extends Controller
{
    public function blogs(Request $request): JsonResponse
    {
        $query = Blog::active()->ordered();

        if ($request->has('limit')) {
            $limit = (int) $request->input('limit');
            if ($limit > 0) {
                $query->take($limit);
            }
        }

        $blogs = $query->get()
            ->map(fn (Blog $blog) => $blog->toApiFormat());

        return response()->json([
            'posts' => $blogs,
        ]);
    }

    public function blog(int $id): JsonResponse
    {
        $blog = Blog::active()->find($id);

        if (!$blog) {
            return response()->json([
                'found' => false,
                'message' => 'Blog no encontrado',
            ], 404);
        }

        return response()->json([
            'post' => $blog->toApiFormat(),
        ]);
    }

    public function services(): JsonResponse
    {
        $services = Service::active()
            ->ordered()
            ->get()
            ->map(fn (Service $service) => $service->toApiFormat());

        return response()->json([
            'services' => $services,
        ]);
    }

    public function breeders(): JsonResponse
    {
        $breeders = Breeder::active()
            ->ordered()
            ->get()
            ->map(fn (Breeder $breeder) => $breeder->toApiFormat());

        return response()->json([
            'breeders' => $breeders,
        ]);
    }

    public function certificates(): JsonResponse
    {
        $certificates = Certificate::active()
            ->get()
            ->map(fn (Certificate $certificate) => $certificate->toApiFormat());

        return response()->json([
            'certificates' => $certificates,
        ]);
    }

    public function validateCertificate(string $microchip): JsonResponse
    {
        $certificate = Certificate::where('microchip', $microchip)
            ->orWhere('registration_number', $microchip)
            ->first();

        if (!$certificate) {
            return response()->json([
                'found' => false,
                'message' => 'Certificado no encontrado',
            ], 404);
        }

        return response()->json([
            'found' => true,
            'certificate' => $certificate->toApiFormat(),
        ]);
    }

    public function events(): JsonResponse
    {
        $events = Event::active()
            ->ordered()
            ->get()
            ->map(fn (Event $event) => $event->toApiFormat());

        return response()->json([
            'events' => $events,
        ]);
    }

    public function schools(): JsonResponse
    {
        $schools = School::active()
            ->ordered()
            ->get()
            ->map(fn (School $school) => $school->toApiFormat());

        return response()->json([
            'schools' => $schools,
        ]);
    }

    public function judges(): JsonResponse
    {
        $judges = Judge::active()
            ->ordered()
            ->get()
            ->map(fn (Judge $judge) => $judge->toApiFormat());

        return response()->json([
            'judges' => $judges,
        ]);
    }

    public function header(): JsonResponse
    {
        $settings = SiteSetting::getByGroup('header');

        return response()->json([
            'logo' => $settings['logo'] ?? null,
            'ctaButton' => $settings['ctaButton'] ?? null,
            'menuItems' => $settings['menuItems'] ?? [],
            'socialLinks' => $settings['socialLinks'] ?? [],
            'contactInfo' => $settings['contactInfo'] ?? null,
        ]);
    }

    public function footer(): JsonResponse
    {
        $settings = SiteSetting::getByGroup('footer');

        return response()->json([
            'logo' => $settings['logo'] ?? null,
            'name' => $settings['name'] ?? '',
            'legend' => $settings['legend'] ?? '',
        ]);
    }
}


