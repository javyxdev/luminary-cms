<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Dj;
use App\Models\Setting;

class DjsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $djs      = Dj::orderBy('sort_order')->get();

        return view('public.djs', compact('settings', 'djs'));
    }
}
