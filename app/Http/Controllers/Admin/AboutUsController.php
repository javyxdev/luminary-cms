<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::firstOrCreate(['id' => 1], [
            'title'   => 'Nuestra Historia',
            'content' => '',
        ]);
        return view('admin.about_us.edit', compact('aboutUs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title'      => 'required|max:255',
            'content'    => 'required',
            'vision'     => 'nullable',
            'mission'    => 'nullable',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
        ]);

        $aboutUs = AboutUs::find(1);
        $data    = $request->only(['title', 'content', 'vision', 'mission']);

        if ($request->hasFile('hero_image')) {
            if ($aboutUs->hero_image_path) {
                Storage::disk('public')->delete($aboutUs->hero_image_path);
            }
            $data['hero_image_path'] = ImageOptimizer::store($request->file('hero_image'), 'about', maxWidth: 1920);
        }

        $aboutUs->update($data);

        return redirect()->back()->with('success', 'Información de Sobre Nosotros actualizada.');
    }
}
