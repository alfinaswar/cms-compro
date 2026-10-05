<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Berita;
use App\Models\ContactUs;
use App\Models\LamaranKerja;
use App\Models\LowonganKerja;
use App\Models\StrukturOrganisasiDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:dashboard.view')->only(['index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countArtikel = Berita::where('Status', 'Diterbitkan')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $countArtikelDraftBulanIni = Berita::where('Status', 'Draf')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $countLowongan = LowonganKerja::where('Status', 'Buka')->count();
        $countPesan = ContactUs::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $countPelamar = LamaranKerja::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $countAnggota = StrukturOrganisasiDetail::where('Status', 'Aktif')->count();
        $artikelTerbaru = Berita::where('Status', 'Diterbitkan')
            ->with([
                'translations' => function ($query) {
                    $query->where('Locale', 'id');
                }
            ])
            ->latest('TanggalPublikasi')
            ->take(5)
            ->get();

        $pesanTerbaru = ContactUs::latest()->take(5)->get();
        $chartPesan = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartPesan[] = ContactUs::whereDate('created_at', $date)->count();
        }
        $recentActivity = ActivityLog::latest()->take(10)->get();

        return view('home', compact(
            'countArtikel',
            'countArtikelDraftBulanIni',
            'countLowongan',
            'countPesan',
            'countAnggota',
            'artikelTerbaru',
            'pesanTerbaru',
            'chartPesan',
            'recentActivity',
            'countPelamar'
        ));
    }
}
