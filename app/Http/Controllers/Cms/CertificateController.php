<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CertificateController extends Controller
{
    public function index(): Response
    {
        $certificates = Certificate::query()
            ->orderByDesc('certificate_date')
            ->paginate(15);

        return Inertia::render('cms/certificates/Index', [
            'certificates' => $certificates,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('cms/certificates/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'microchip' => 'required|string|max:50|unique:certificates,microchip',
            'registration_number' => 'required|string|max:50|unique:certificates,registration_number',
            'name' => 'required|string|max:255',
            'breed' => 'nullable|string|max:100',
            'variety' => 'nullable|string|max:100',
            'sex' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:100',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'image' => 'nullable|string',
            'valid' => 'boolean',
            'certificate_number' => 'nullable|string|max:50',
            'certificate_date' => 'nullable|date',
            'breeder' => 'nullable|string|max:255',
            'owner' => 'nullable|string|max:255',
            'co_owner' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'neighborhood' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'titles' => 'nullable|array',
            'observations' => 'nullable|string',
            'status' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        Certificate::create($validated);

        return redirect()->route('cms.certificates.index')
            ->with('success', 'Certificado creado correctamente.');
    }

    public function edit(Certificate $certificate): Response
    {
        return Inertia::render('cms/certificates/Edit', [
            'certificate' => $certificate,
        ]);
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'microchip' => 'required|string|max:50|unique:certificates,microchip,' . $certificate->id,
            'registration_number' => 'required|string|max:50|unique:certificates,registration_number,' . $certificate->id,
            'name' => 'required|string|max:255',
            'breed' => 'nullable|string|max:100',
            'variety' => 'nullable|string|max:100',
            'sex' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:100',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'image' => 'nullable|string',
            'valid' => 'boolean',
            'certificate_number' => 'nullable|string|max:50',
            'certificate_date' => 'nullable|date',
            'breeder' => 'nullable|string|max:255',
            'owner' => 'nullable|string|max:255',
            'co_owner' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'neighborhood' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'titles' => 'nullable|array',
            'observations' => 'nullable|string',
            'status' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $certificate->update($validated);

        return redirect()->route('cms.certificates.index')
            ->with('success', 'Certificado actualizado correctamente.');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return redirect()->route('cms.certificates.index')
            ->with('success', 'Certificado eliminado correctamente.');
    }
}



