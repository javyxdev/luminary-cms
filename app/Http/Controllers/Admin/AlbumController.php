<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Event;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('event')->latest()->get();
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $events = Event::orderBy('title')->get();
        return view('admin.albums.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'event_id'    => 'nullable|exists:events,id',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = ImageOptimizer::store($request->file('cover_image'), 'albums', maxWidth: 1200);
        }

        Album::create([
            'title'            => $request->title,
            'slug'             => Str::slug($request->title),
            'description'      => $request->description,
            'cover_image_path' => $coverPath,
            'event_id'         => $request->event_id,
            'is_active'        => $request->has('is_active'),
        ]);

        return redirect()->route('albums.index')->with('success', 'Álbum creado con éxito.');
    }

    public function edit(Album $album)
    {
        $events = Event::orderBy('title')->get();
        return view('admin.albums.edit', compact('album', 'events'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'event_id'    => 'nullable|exists:events,id',
        ]);

        $data = $request->only(['title', 'description', 'event_id']);
        $data['slug']      = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image_path) {
                Storage::disk('public')->delete($album->cover_image_path);
            }
            $data['cover_image_path'] = ImageOptimizer::store($request->file('cover_image'), 'albums', maxWidth: 1200);
        }

        $album->update($data);

        return redirect()->route('albums.index')->with('success', 'Álbum actualizado con éxito.');
    }

    public function destroy(Album $album)
    {
        if ($album->cover_image_path) {
            Storage::disk('public')->delete($album->cover_image_path);
        }
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Álbum eliminado con éxito.');
    }
}
