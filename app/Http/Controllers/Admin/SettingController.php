<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $fileFields = ['site_logo', 'admin_logo', 'hero_bg_file', 'home_about_image',
                       'hero_slide_1', 'hero_slide_2', 'hero_slide_3', 'hero_slide_4'];

        $data = $request->except(array_merge(['_token', '_method'], $fileFields));

        // 1. Actualizar textos simples
        foreach ($data as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        // 2. Logo del Sitio Web Público
        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::getValue('site_logo');
            if ($oldLogo && !str_contains($oldLogo, 'assets/img/')) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = ImageOptimizer::store($request->file('site_logo'), 'settings', maxWidth: 600);
            Setting::where('key', 'site_logo')->update(['value' => $path]);
        }

        // 3. Logo del Panel Administrativo
        if ($request->hasFile('admin_logo')) {
            $oldLogo = Setting::getValue('admin_logo');
            if ($oldLogo && !str_contains($oldLogo, 'assets/img/')) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = ImageOptimizer::store($request->file('admin_logo'), 'settings', maxWidth: 600);
            Setting::where('key', 'admin_logo')->update(['value' => $path]);
        }

        // 4. Imagen sección Historia (Home)
        if ($request->hasFile('home_about_image')) {
            $old = Setting::getValue('home_about_image');
            if ($old) Storage::disk('public')->delete($old);
            $path = ImageOptimizer::store($request->file('home_about_image'), 'settings', maxWidth: 1200);
            Setting::where('key', 'home_about_image')->update(['value' => $path]);
        }

        // 5. Archivo del Hero (Imagen o Video Local)
        if ($request->hasFile('hero_bg_file')) {
            $oldFile = Setting::getValue('hero_bg_path');
            if ($oldFile) Storage::disk('public')->delete($oldFile);
            $bgType = $request->input('hero_bg_type', Setting::getValue('hero_bg_type', 'image'));
            if ($bgType === 'image') {
                $path = ImageOptimizer::store($request->file('hero_bg_file'), 'hero', maxWidth: 1920);
            } else {
                $path = $request->file('hero_bg_file')->store('hero', 'public');
            }
            Setting::where('key', 'hero_bg_path')->update(['value' => $path]);
        }

        // 6. Slides del Hero Slider (hasta 4 imágenes)
        foreach (['hero_slide_1', 'hero_slide_2', 'hero_slide_3', 'hero_slide_4'] as $slideKey) {
            if ($request->hasFile($slideKey)) {
                $old = Setting::getValue($slideKey);
                if ($old) Storage::disk('public')->delete($old);
                $path = ImageOptimizer::store($request->file($slideKey), 'hero/slides', maxWidth: 1920);
                Setting::where('key', $slideKey)->update(['value' => $path]);
            }
        }

        return redirect()->back()->with('success', 'Configuraciones actualizadas con éxito.');
    }

    public function deleteSlide(string $key)
    {
        $allowed = ['hero_slide_1', 'hero_slide_2', 'hero_slide_3', 'hero_slide_4'];

        if (!in_array($key, $allowed)) {
            return response()->json(['error' => 'Clave no válida.'], 422);
        }

        $path = Setting::getValue($key);

        if ($path) {
            Storage::disk('public')->delete($path);
            Setting::where('key', $key)->update(['value' => '']);
        }

        return response()->json(['success' => true]);
    }
}
