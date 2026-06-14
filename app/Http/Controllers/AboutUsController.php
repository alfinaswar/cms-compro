<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\HistoryPerusahaan;
use App\Models\PenghargaanPerusahaan;
use App\Models\ValuePerusahaan;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $history = HistoryPerusahaan::first();
        $value = ValuePerusahaan::first();
        $sertifikat = PenghargaanPerusahaan::with('details')->first();
        return view('frontend.about', compact(
            'value',
            'history',
            'sertifikat',
        ));
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(AboutUs $aboutUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutUs $aboutUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AboutUs $aboutUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutUs $aboutUs)
    {
        //
    }
}
