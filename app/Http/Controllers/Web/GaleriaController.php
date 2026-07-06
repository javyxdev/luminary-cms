<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Setting;
use Illuminate\Support\Facades\Abort;

class GaleriaController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $albums   = Album::where('is_active', true)
                        ->withCount('gallery')
                        ->with(['gallery' => fn($q) => $q->orderBy('id')->limit(1)])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('public.galeria', compact('settings', 'albums'));
    }

    public function show(string $slug)
    {
        $settings = Setting::all()->pluck('value', 'key');
        $album    = Album::where('slug', $slug)
                        ->where('is_active', true)
                        ->with(['gallery', 'event'])
                        ->firstOrFail();

        return view('public.galeria_album', compact('settings', 'album'));
    }
}
