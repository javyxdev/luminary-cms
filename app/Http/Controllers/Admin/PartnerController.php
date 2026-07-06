<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'description' => 'nullable',
            'logo'        => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:15360',
            'website_url' => 'nullable|url',
        ]);

        Partner::create([
            'name'        => $request->name,
            'description' => $request->description,
            'logo_path'   => ImageOptimizer::store($request->file('logo'), 'partners', maxWidth: 900, quality: 88),
            'website_url' => $request->website_url,
        ]);

        return redirect()->route('partners.index')->with('success', 'Aliado registrado con éxito.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'description' => 'nullable',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:15360',
            'website_url' => 'nullable|url',
        ]);

        $data = $request->only(['name', 'description', 'website_url']);

        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($partner->logo_path);
            $data['logo_path'] = ImageOptimizer::store($request->file('logo'), 'partners', maxWidth: 900, quality: 88);
        }

        $partner->update($data);

        return redirect()->route('partners.index')->with('success', 'Información del aliado actualizada.');
    }

    public function destroy(Partner $partner)
    {
        Storage::disk('public')->delete($partner->logo_path);
        $partner->delete();
        return redirect()->route('partners.index')->with('success', 'Aliado eliminado con éxito.');
    }
}
