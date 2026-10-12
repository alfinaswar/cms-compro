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

        $countArtikelDraftBulanIni = Berita::whereIn('Status', ['Draf', 'Draft'])->count();

        $countLowongan = LowonganKerja::where('Status', 'Buka')->count();
        $countPesan = ContactUs::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $countPelamar = LamaranKerja::whereHas('getLowongan')->count();

        $countUser = \App\Models\User::count();
        $countAnggota = StrukturOrganisasiDetail::where('Status', 'Aktif')->count();
        $artikelTerbaru = Berita::whereIn('Status', ['Diterbitkan', 'Terbit'])
            ->with('translations')
            ->latest('TanggalPublikasi')
            ->latest('id')
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
            'countUser',
            'countAnggota',
            'artikelTerbaru',
            'pesanTerbaru',
            'chartPesan',
            'recentActivity',
            'countPelamar'
        ));
    }
}
