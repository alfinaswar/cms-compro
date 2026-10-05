<?php

namespace App\Http\Controllers;

use App\Models\InformasiSaham;
use App\Models\StrukturKepemilikan;
use App\Models\SkemaPengendali;
use App\Models\EntitasAnak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminInvestorFinansialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:investor.view')->only(['index']);
        $this->middleware('permission:investor.create')->only(['storeStruktur', 'storeEntitas']);
        $this->middleware('permission:investor.edit')->only(['updateSaham', 'updateStruktur', 'updateSkema', 'updateEntitas']);
        $this->middleware('permission:investor.delete')->only(['destroyStruktur', 'destroyEntitas']);
    }

    public function index()
    {
        $saham = InformasiSaham::first() ?? new InformasiSaham(['KodeSaham' => 'JTPE']);
        $strukturList = StrukturKepemilikan::orderBy('TipePemodal')->orderBy('Urutan')->get();
        $skema = SkemaPengendali::first() ?? new SkemaPengendali();
        $entitasList = EntitasAnak::orderBy('Urutan')->get();

        return view('master.investor.informasi-finansial.index', compact('saham', 'strukturList', 'skema', 'entitasList'));
    }

    // --- 1. Update Saham JTPE ---
    public function updateSaham(Request $request)
    {
        $validated = $request->validate([
            'KodeSaham' => 'required|string|max:20',
            'HargaTerakhir' => 'required|numeric',
            'Perubahan' => 'required|numeric',
            'PersentasePerubahan' => 'required|numeric',
            'StatusPasar' => 'required|string|max:255',
            'Pembukaan' => 'required|numeric',
            'PenutupanKemarin' => 'required|numeric',
            'TertinggiHariIni' => 'required|numeric',
            'TerendahHariIni' => 'required|numeric',
            'Tertinggi52Mgg' => 'required|numeric',
            'Terendah52Mgg' => 'required|numeric',
            'VolumeSaham' => 'required|integer',
            'NilaiTransaksi' => 'required|string|max:100',
            'KapitalisasiPasar' => 'required|string|max:100',
        ]);

        $validated['UserUpdate'] = auth()->user()->name;

        $saham = InformasiSaham::first();
        if ($saham) {
            $oldData = $saham->getOriginal();
            $saham->update($validated);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($saham)
                ->withProperties(['old' => $oldData, 'attributes' => $validated])
                ->log('Memperbarui data informasi saham JTPE');
        } else {
            $validated['UserCreate'] = auth()->user()->name;
            $saham = InformasiSaham::create($validated);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($saham)
                ->withProperties(['attributes' => $validated])
                ->log('Memperbarui data informasi saham JTPE');
        }

        return redirect()->back()->with('success', 'Data informasi saham JTPE berhasil diperbarui.');
    }

    // --- 2. CRUD Struktur Kepemilikan ---
    public function storeStruktur(Request $request)
    {
        $validated = $request->validate([
            'TipePemodal' => 'required|in:Pemodal Nasional,Pemodal Asing',
            'KategoriPemegang' => 'required|string|max:255',
            'JumlahSaham' => 'required|integer|min:0',
            'Persentase' => 'required|numeric|min:0|max:100',
            'PeriodeBulan' => 'required|string|max:30',
            'PeriodeTahun' => 'required|string|max:10',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['UserCreate'] = auth()->user()->name;
        $struktur = StrukturKepemilikan::create($validated);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($struktur)
            ->withProperties(['attributes' => $validated])
            ->log('Menambahkan struktur kepemilikan: ' . $validated['KategoriPemegang']);

        return redirect()->back()->with('success', 'Baris struktur kepemilikan saham berhasil ditambahkan.');
    }

    public function updateStruktur(Request $request, $id)
    {
        $item = StrukturKepemilikan::findOrFail($id);

        $validated = $request->validate([
            'TipePemodal' => 'required|in:Pemodal Nasional,Pemodal Asing',
            'KategoriPemegang' => 'required|string|max:255',
            'JumlahSaham' => 'required|integer|min:0',
            'Persentase' => 'required|numeric|min:0|max:100',
            'PeriodeBulan' => 'required|string|max:30',
            'PeriodeTahun' => 'required|string|max:10',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['UserUpdate'] = auth()->user()->name;
        $oldData = $item->getOriginal();
        $item->update($validated);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($item)
            ->withProperties(['old' => $oldData, 'attributes' => $validated])
            ->log('Memperbarui struktur kepemilikan: ' . $validated['KategoriPemegang']);

        return redirect()->back()->with('success', 'Struktur kepemilikan berhasil diperbarui.');
    }

    public function destroyStruktur($id)
    {
        $item = StrukturKepemilikan::findOrFail($id);
        $item->update(['UserDelete' => auth()->user()->name]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($item)
            ->withProperties(['old' => $item->getOriginal()])
            ->log('Menghapus struktur kepemilikan: ' . $item->KategoriPemegang);
        $item->delete();

        return response()->json(['status' => 200, 'message' => 'Data kepemilikan berhasil dihapus.']);
    }

    // --- 3. Update Skema Pengendali ---
    public function updateSkema(Request $request)
    {
        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'Keterangan' => 'nullable|string',
            'GambarBagan' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'FileSkemaPdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $skema = SkemaPengendali::first() ?? new SkemaPengendali();

        if ($request->hasFile('GambarBagan')) {
            if ($skema->PathGambar && Storage::disk('public')->exists($skema->PathGambar)) {
                Storage::disk('public')->delete($skema->PathGambar);
            }
            $validated['PathGambar'] = $request->file('GambarBagan')->store('investor/skema', 'public');
        }

        if ($request->hasFile('FileSkemaPdf')) {
            if ($skema->PathFilePdf && Storage::disk('public')->exists($skema->PathFilePdf)) {
                Storage::disk('public')->delete($skema->PathFilePdf);
            }
            $validated['PathFilePdf'] = $request->file('FileSkemaPdf')->store('investor/skema', 'public');
        }

        $validated['UserUpdate'] = auth()->user()->name;

        if ($skema->exists) {
            $oldData = $skema->getOriginal();
            $skema->update($validated);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($skema)
                ->withProperties(['old' => $oldData, 'attributes' => $validated])
                ->log('Memperbarui skema pengendali: ' . $validated['Judul']);
        } else {
            $validated['UserCreate'] = auth()->user()->name;
            $skema = SkemaPengendali::create($validated);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($skema)
                ->withProperties(['attributes' => $validated])
                ->log('Memperbarui skema pengendali: ' . $validated['Judul']);
        }

        return redirect()->back()->with('success', 'Bagan skema pengendali berhasil diperbarui.');
    }

    // --- 4. CRUD Entitas Anak & Asosiasi ---
    public function storeEntitas(Request $request)
    {
        $validated = $request->validate([
            'NamaEntitas' => 'required|string|max:255',
            'Lokasi' => 'nullable|string|max:255',
            'Tipe' => 'required|in:Entitas Anak,Perusahaan Asosiasi',
            'PersentaseKepemilikan' => 'required|numeric|min:0|max:100',
            'TahunBergabung' => 'nullable|string|max:50',
            'BidangUsaha' => 'nullable|string',
            'UrlWebsite' => 'nullable|url|max:255',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['UserCreate'] = auth()->user()->name;
        EntitasAnak::create($validated);

        return redirect()->back()->with('success', 'Entitas anak / asosiasi berhasil ditambahkan.');
    }

    public function updateEntitas(Request $request, $id)
    {
        $entitas = EntitasAnak::findOrFail($id);

        $validated = $request->validate([
            'NamaEntitas' => 'required|string|max:255',
            'Lokasi' => 'nullable|string|max:255',
            'Tipe' => 'required|in:Entitas Anak,Perusahaan Asosiasi',
            'PersentaseKepemilikan' => 'required|numeric|min:0|max:100',
            'TahunBergabung' => 'nullable|string|max:50',
            'BidangUsaha' => 'nullable|string',
            'UrlWebsite' => 'nullable|url|max:255',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['UserUpdate'] = auth()->user()->name;
        $entitas->update($validated);

        return redirect()->back()->with('success', 'Data entitas berhasil diperbarui.');
    }

    public function destroyEntitas($id)
    {
        $entitas = EntitasAnak::findOrFail($id);
        $entitas->update(['UserDelete' => auth()->user()->name]);
        $entitas->delete();

        return response()->json(['status' => 200, 'message' => 'Entitas berhasil dihapus.']);
    }
}
