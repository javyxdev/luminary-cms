<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Setting;

class EventosController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $events   = Event::where('is_active', true)
                        ->orderBy('event_date', 'desc')
                        ->get();

        return view('public.eventos', compact('settings', 'events'));
    }
}
