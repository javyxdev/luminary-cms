<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Dj;
use App\Models\Gallery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $eventsCount = Event::count();
        $djsCount = Dj::count();
        $galleryCount = Gallery::count();

        return view('admin.dashboard', compact('eventsCount', 'djsCount', 'galleryCount'));
    }
}
