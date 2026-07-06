<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Dj;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $settings   = Setting::all()->pluck('value', 'key');
        $about      = AboutUs::first();
        $partners   = Partner::all();
        $djsCount   = Dj::count();
        $eventsCount = Event::count();

        return view('public.home', compact('settings', 'about', 'partners', 'djsCount', 'eventsCount'));
    }
}
