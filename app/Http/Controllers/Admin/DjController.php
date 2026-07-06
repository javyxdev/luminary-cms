<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dj;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DjController extends Controller
{
    public function index()
    {
        $djs = Dj::orderBy('sort_order')->get();
        return view('admin.djs.index', compact('djs'));
    }

    public function create()
    {
        return view('admin.djs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'biography'     => 'required',
            'image'         => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
            'facebook_url'  => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'soundcloud_url'=> 'nullable|url',
            'beatport_url'  => 'nullable|url',
            'tiktok_url'    => 'nullable|url',
        ]);

        Dj::create([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'biography'     => $request->biography,
            'image_path'    => ImageOptimizer::store($request->file('image'), 'djs', maxWidth: 1200),
            'facebook_url'  => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'soundcloud_url'=> $request->soundcloud_url,
            'beatport_url'  => $request->beatport_url,
            'tiktok_url'    => $request->tiktok_url,
            'sort_order'    => $request->sort_order ?? 0,
        ]);

        return redirect()->route('djs.index')->with('success', 'DJ registrado con éxito.');
    }

    public function edit(Dj $dj)
    {
        return view('admin.djs.edit', compact('dj'));
    }

    public function update(Request $request, Dj $dj)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'biography'     => 'required',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'facebook_url'  => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'soundcloud_url'=> 'nullable|url',
            'beatport_url'  => 'nullable|url',
            'tiktok_url'    => 'nullable|url',
        ]);

        $data = $request->only(['name', 'biography', 'facebook_url', 'instagram_url', 'soundcloud_url', 'beatport_url', 'tiktok_url', 'sort_order']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($dj->image_path);
            $data['image_path'] = ImageOptimizer::store($request->file('image'), 'djs', maxWidth: 1200);
        }

        $dj->update($data);

        return redirect()->route('djs.index')->with('success', 'Información del DJ actualizada.');
    }

    public function destroy(Dj $dj)
    {
        Storage::disk('public')->delete($dj->image_path);
        $dj->delete();
        return redirect()->route('djs.index')->with('success', 'DJ eliminado del sistema.');
    }
}
