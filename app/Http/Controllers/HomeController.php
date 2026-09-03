<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\ContactUs;
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // === COUNT DATA UTAMA ===
        $countArtikel = Berita::where('Status', 'Diterbitkan')->count();
        $countLowongan = LowonganKerja::where('Status', 'Buka')->count();
        $countPesan = ContactUs::count();
        $countAnggota = StrukturOrganisasiDetail::where('Status', 'Aktif')->count();

        // === DATA TERBARU (Untuk Widget Activity) ===
        $artikelTerbaru = Berita::where('Status', 'Diterbitkan')
            ->latest('TanggalPublikasi')
            ->take(5)
            ->get(['id', 'Judul', 'TanggalPublikasi', 'PathThumbnail']);

        $pesanTerbaru = ContactUs::latest()->take(5)->get(['id', 'NamaLengkap', 'Email', 'created_at']);

        // === DATA CHART (Opsional - Contoh 7 hari terakhir) ===
        $chartPesan = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartPesan[] = ContactUs::whereDate('created_at', $date)->count();
        }

        return view('home', compact(
            'countArtikel',
            'countLowongan',
            'countPesan',
            'countAnggota',
            'artikelTerbaru',
            'pesanTerbaru',
            'chartPesan'
        ));
    }
}
