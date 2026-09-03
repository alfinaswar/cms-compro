<?php

namespace App\Http\Controllers;

use App\Models\ClientLogo;
use App\Models\HalamanSolusi;
use App\Models\HeroSlider;
use App\Models\KeyFigures;
use App\Models\PengaturanWebsite;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Di controller yang handle landing page
    public function index()
    {
        $heroSliders = HeroSlider::where('Status', 1)
            ->orderBy('Urutan', 'asc')
            ->get();
// dd($heroSliders);
        $websiteSettings = PengaturanWebsite::first();
        $KeyFigures = KeyFigures::get();
        $Solution = HalamanSolusi::get();
        $Why = WhyChooseUs::get();
        $logo =  ClientLogo::with('details')->get();
        return view('frontend.main', compact('logo','heroSliders', 'websiteSettings','KeyFigures','Solution','Why'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
