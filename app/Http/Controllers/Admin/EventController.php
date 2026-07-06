<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest('event_date')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|max:255',
            'description'   => 'required',
            'event_date'    => 'required|date',
            'location'      => 'required|max:255',
            'image'         => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
            'external_link' => 'nullable|url',
        ]);

        Event::create([
            'title'         => $request->title,
            'slug'          => Str::slug($request->title),
            'description'   => $request->description,
            'event_date'    => $request->event_date,
            'location'      => $request->location,
            'image_path'    => ImageOptimizer::store($request->file('image'), 'events', maxWidth: 1920),
            'external_link' => $request->external_link,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()->route('events.index')->with('success', 'Evento creado con éxito.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'         => 'required|max:255',
            'description'   => 'required',
            'event_date'    => 'required|date',
            'location'      => 'required|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'external_link' => 'nullable|url',
        ]);

        $data = $request->only(['title', 'description', 'event_date', 'location', 'external_link']);
        $data['slug']      = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($event->image_path);
            $data['image_path'] = ImageOptimizer::store($request->file('image'), 'events', maxWidth: 1920);
        }

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Evento actualizado con éxito.');
    }

    public function destroy(Event $event)
    {
        Storage::disk('public')->delete($event->image_path);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento eliminado del sistema.');
    }
}
