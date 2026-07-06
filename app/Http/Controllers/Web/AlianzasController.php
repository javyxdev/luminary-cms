<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Setting;

class AlianzasController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $partners = Partner::all();

        return view('public.alianzas', compact('settings', 'partners'));
    }
}
