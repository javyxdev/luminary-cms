<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Album;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('album')->latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        $albums = Album::orderBy('title')->get();
        return view('admin.gallery.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'nullable|max:255',
            'image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
            'category' => 'required|in:event,backstage,artist',
            'album_id' => 'required|exists:albums,id',
        ]);

        Gallery::create([
            'title'      => $request->title,
            'image_path' => ImageOptimizer::store($request->file('image'), 'gallery', maxWidth: 1920, quality: 80),
            'category'   => $request->category,
            'album_id'   => $request->album_id,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Imagen añadida a la galería con éxito.');
    }

    public function edit(Gallery $gallery)
    {
        $albums = Album::orderBy('title')->get();
        return view('admin.gallery.edit', compact('gallery', 'albums'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title'    => 'nullable|max:255',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'category' => 'required|in:event,backstage,artist',
            'album_id' => 'required|exists:albums,id',
        ]);

        $data = $request->only(['title', 'category', 'album_id']);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image_path);
            $data['image_path'] = ImageOptimizer::store($request->file('image'), 'gallery', maxWidth: 1920, quality: 80);
        }

        $gallery->update($data);

        return redirect()->route('gallery.index')->with('success', 'Información de la galería actualizada.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();
        return redirect()->route('gallery.index')->with('success', 'Imagen eliminada de la galería.');
    }
}
