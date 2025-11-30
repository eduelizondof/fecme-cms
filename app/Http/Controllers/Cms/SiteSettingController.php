<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SiteSettingController extends Controller
{
    public function index(): Response
    {
        $headerSettings = SiteSetting::getByGroup('header');
        $footerSettings = SiteSetting::getByGroup('footer');

        return Inertia::render('cms/settings/Index', [
            'headerSettings' => $headerSettings,
            'footerSettings' => $footerSettings,
        ]);
    }

    public function updateHeader(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'nullable|array',
            'ctaButton' => 'nullable|array',
            'menuItems' => 'nullable|array',
            'socialLinks' => 'nullable|array',
            'contactInfo' => 'nullable|array',
        ]);

        foreach ($validated as $key => $value) {
            // Convertir null a valores por defecto apropiados
            if ($value === null) {
                if (in_array($key, ['menuItems', 'socialLinks'])) {
                    $value = [];
                } else {
                    $value = [];
                }
            }
            SiteSetting::setByKey($key, $value, 'header');
        }

        return redirect()->route('cms.settings.index')
            ->with('success', 'Configuración del header actualizada correctamente.');
    }

    public function updateFooter(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'nullable|array',
            'name' => 'nullable|string',
            'legend' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            // Convertir null a valores por defecto apropiados
            if ($value === null) {
                if ($key === 'logo') {
                    $value = [];
                } else {
                    $value = '';
                }
            }
            SiteSetting::setByKey($key, $value, 'footer');
        }

        return redirect()->route('cms.settings.index')
            ->with('success', 'Configuración del footer actualizada correctamente.');
    }
}

