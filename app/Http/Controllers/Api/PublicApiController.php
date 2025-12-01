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

    public function blog(string $slug): JsonResponse
    {
        $blog = Blog::active()->where('slug', $slug)->first();

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

    public function services(Request $request): JsonResponse
    {
        $query = Service::active()->ordered();

        if ($request->has('showInServices')) {
            $showInServices = filter_var($request->input('showInServices'), FILTER_VALIDATE_BOOLEAN);
            if ($showInServices) {
                $query->showInServices();
            }
        }

        if ($request->has('showInPricing')) {
            $showInPricing = filter_var($request->input('showInPricing'), FILTER_VALIDATE_BOOLEAN);
            if ($showInPricing) {
                $query->showInPricing();
            }
        }

        if ($request->has('limit')) {
            $limit = (int) $request->input('limit');
            if ($limit > 0) {
                $query->take($limit);
            }
        }

        $services = $query->get()
            ->map(fn (Service $service) => $service->toApiFormat());

        return response()->json([
            'services' => $services,
        ]);
    }

    public function service(string $slug): JsonResponse
    {
        $service = Service::active()->where('slug', $slug)->first();

        if (!$service) {
            return response()->json([
                'found' => false,
                'message' => 'Servicio no encontrado',
            ], 404);
        }

        return response()->json([
            'service' => $service->toApiFormat(),
        ]);
    }

    public function breeders(Request $request): JsonResponse
    {
        $query = Breeder::active()->ordered();

        if ($request->has('limit')) {
            $limit = (int) $request->input('limit');
            if ($limit > 0) {
                $query->take($limit);
            }
        }

        $breeders = $query->get()
            ->map(fn (Breeder $breeder) => $breeder->toApiListFormat());

        return response()->json([
            'breeders' => $breeders,
        ]);
    }

    public function breeder(string $slug): JsonResponse
    {
        $breeder = Breeder::active()->where('slug', $slug)->first();

        if (!$breeder) {
            return response()->json([
                'found' => false,
                'message' => 'Criador no encontrado',
            ], 404);
        }

        return response()->json([
            'breeder' => $breeder->toApiFormat(),
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

    public function events(Request $request): JsonResponse
    {
        $query = Event::active()->ordered();

        if ($request->has('limit')) {
            $limit = (int) $request->input('limit');
            if ($limit > 0) {
                $query->take($limit);
            }
        }

        $events = $query->get()
            ->map(fn (Event $event) => $event->toApiFormat());

        return response()->json([
            'events' => $events,
        ]);
    }

    public function event(string $slug): JsonResponse
    {
        $event = Event::active()->where('slug', $slug)->first();

        if (!$event) {
            return response()->json([
                'found' => false,
                'message' => 'Evento no encontrado',
            ], 404);
        }

        return response()->json([
            'event' => $event->toApiFormat(),
        ]);
    }

    public function schools(Request $request): JsonResponse
    {
        $query = School::active()->ordered();

        if ($request->has('limit')) {
            $limit = (int) $request->input('limit');
            if ($limit > 0) {
                $query->take($limit);
            }
        }

        $schools = $query->get()
            ->map(fn (School $school) => $school->toApiFormat());

        return response()->json([
            'schools' => $schools,
        ]);
    }

    public function school(string $slug): JsonResponse
    {
        $school = School::active()->where('slug', $slug)->first();

        if (!$school) {
            return response()->json([
                'found' => false,
                'message' => 'Escuela no encontrada',
            ], 404);
        }

        return response()->json([
            'school' => $school->toApiFormat(),
        ]);
    }

    public function judges(Request $request): JsonResponse
    {
        $query = Judge::active()->ordered();

        if ($request->has('limit')) {
            $limit = (int) $request->input('limit');
            if ($limit > 0) {
                $query->take($limit);
            }
        }

        $judges = $query->get()
            ->map(fn (Judge $judge) => $judge->toApiFormat());

        return response()->json([
            'judges' => $judges,
        ]);
    }

    public function judge(int $id): JsonResponse
    {
        $judge = Judge::active()->find($id);

        if (!$judge) {
            return response()->json([
                'found' => false,
                'message' => 'Juez no encontrado',
            ], 404);
        }

        return response()->json([
            'judge' => $judge->toApiFormat(),
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


