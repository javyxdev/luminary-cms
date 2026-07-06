<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Setting;

class NosotrosController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $about    = AboutUs::first();

        return view('public.nosotros', compact('settings', 'about'));
    }
}
