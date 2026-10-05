<?php

namespace App\Http\Controllers;

use App\Models\LembagaPenunjang;
use App\Models\KeterbukaanInformasi;
use App\Models\PermintaanDokumenInvestor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminInvestorInformasiLainnyaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:investor.view')->only(['index', 'permintaanIndex']);
        $this->middleware('permission:investor.create')->only(['storeLembaga', 'storeKeterbukaan']);
        $this->middleware('permission:investor.edit')->only(['updateLembaga', 'updateKeterbukaan', 'permintaanUpdateStatus']);
        $this->middleware('permission:investor.delete')->only(['destroyLembaga', 'destroyKeterbukaan', 'permintaanDestroy']);
    }

    public function index()
    {
        $lembagaList = LembagaPenunjang::orderBy('Kategori')->orderBy('Urutan')->get();
        $keterbukaanList = KeterbukaanInformasi::orderBy('TanggalPublikasi', 'desc')->orderBy('Urutan')->get();
        $permintaanCount = PermintaanDokumenInvestor::where('StatusPermintaan', 'Pending')->count();

        return view('master.investor.informasi-lainnya.index', compact('lembagaList', 'keterbukaanList', 'permintaanCount'));
    }

    // --- 1. CRUD Lembaga Penunjang ---
    public function storeLembaga(Request $request)
    {
        $validated = $request->validate([
            'NamaInstitusi' => 'required|string|max:255',
            'Kategori' => 'required|in:Kantor Akuntan Publik (KAP),Biro Administrasi Efek (BAE),Notaris,Konsultan Hukum,Lainnya',
            'Afiliasi' => 'nullable|string|max:255',
            'Website' => 'nullable|url|max:255',
            'KantorPusat' => 'nullable|string',
            'Cabang' => 'nullable|string',
            'Layanan' => 'nullable|string|max:255',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['UserCreate'] = auth()->user()->name;
        $lembaga = LembagaPenunjang::create($validated);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($lembaga)
            ->withProperties(['attributes' => $validated])
            ->log('Menambahkan lembaga penunjang: ' . $validated['NamaInstitusi']);

        return redirect()->back()->with('success', 'Lembaga penunjang berhasil ditambahkan.');
    }

    public function updateLembaga(Request $request, $id)
    {
        $item = LembagaPenunjang::findOrFail($id);

        $validated = $request->validate([
            'NamaInstitusi' => 'required|string|max:255',
            'Kategori' => 'required|in:Kantor Akuntan Publik (KAP),Biro Administrasi Efek (BAE),Notaris,Konsultan Hukum,Lainnya',
            'Afiliasi' => 'nullable|string|max:255',
            'Website' => 'nullable|url|max:255',
            'KantorPusat' => 'nullable|string',
            'Cabang' => 'nullable|string',
            'Layanan' => 'nullable|string|max:255',
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
            ->log('Memperbarui lembaga penunjang: ' . $validated['NamaInstitusi']);

        return redirect()->back()->with('success', 'Data lembaga penunjang berhasil diperbarui.');
    }

    public function destroyLembaga($id)
    {
        $item = LembagaPenunjang::findOrFail($id);
        $item->update(['UserDelete' => auth()->user()->name]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($item)
            ->withProperties(['old' => $item->getOriginal()])
            ->log('Menghapus lembaga penunjang: ' . $item->NamaInstitusi);

        $item->delete();

        return response()->json(['status' => 200, 'message' => 'Lembaga penunjang berhasil dihapus.']);
    }

    // --- 2. CRUD Keterbukaan Informasi ---
    public function storeKeterbukaan(Request $request)
    {
        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'Kategori' => 'required|in:Fakta Material,Buyback Saham,Aksi Korporasi,Dividen,Buletin Investor,Lainnya',
            'TanggalPublikasi' => 'required|date',
            'Deskripsi' => 'nullable|string',
            'FileDokumen' => 'nullable|file|mimes:pdf|max:15360',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('FileDokumen')) {
            $file = $request->file('FileDokumen');
            $validated['PathFile'] = $file->store('investor/keterbukaan', 'public');
            $validated['FileSize'] = round($file->getSize() / 1024 / 1024, 2) . ' MB';
        }

        $validated['UserCreate'] = auth()->user()->name;
        $keterbukaan = KeterbukaanInformasi::create($validated);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($keterbukaan)
            ->withProperties(['attributes' => $validated])
            ->log('Menambahkan keterbukaan informasi: ' . $validated['Judul']);

        return redirect()->back()->with('success', 'Dokumen keterbukaan informasi berhasil ditambahkan.');
    }

    public function updateKeterbukaan(Request $request, $id)
    {
        $item = KeterbukaanInformasi::findOrFail($id);

        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'Kategori' => 'required|in:Fakta Material,Buyback Saham,Aksi Korporasi,Dividen,Buletin Investor,Lainnya',
            'TanggalPublikasi' => 'required|date',
            'Deskripsi' => 'nullable|string',
            'FileDokumen' => 'nullable|file|mimes:pdf|max:15360',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('FileDokumen')) {
            if ($item->PathFile && Storage::disk('public')->exists($item->PathFile)) {
                Storage::disk('public')->delete($item->PathFile);
            }
            $file = $request->file('FileDokumen');
            $validated['PathFile'] = $file->store('investor/keterbukaan', 'public');
            $validated['FileSize'] = round($file->getSize() / 1024 / 1024, 2) . ' MB';
        }

        $validated['UserUpdate'] = auth()->user()->name;
        $oldData = $item->getOriginal();
        $item->update($validated);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($item)
            ->withProperties(['old' => $oldData, 'attributes' => $validated])
            ->log('Memperbarui keterbukaan informasi: ' . $validated['Judul']);

        return redirect()->back()->with('success', 'Dokumen keterbukaan informasi berhasil diperbarui.');
    }

    public function destroyKeterbukaan($id)
    {
        $item = KeterbukaanInformasi::findOrFail($id);
        if ($item->PathFile && Storage::disk('public')->exists($item->PathFile)) {
            Storage::disk('public')->delete($item->PathFile);
        }
        $item->update(['UserDelete' => auth()->user()->name]);
        $item->delete();

        return response()->json(['status' => 200, 'message' => 'Dokumen keterbukaan berhasil dihapus.']);
    }

    // --- 3. Manajemen Permintaan Salinan Fisik Dokumen ---
    public function permintaanIndex()
    {
        $permintaanList = PermintaanDokumenInvestor::orderBy('created_at', 'desc')->get();
        return view('master.investor.informasi-lainnya.permintaan-index', compact('permintaanList'));
    }

    public function permintaanUpdateStatus(Request $request, $id)
    {
        $item = PermintaanDokumenInvestor::findOrFail($id);
        $validated = $request->validate([
            'StatusPermintaan' => 'required|in:Pending,Diproses,Terkirim,Ditolak',
        ]);

        $validated['UserUpdate'] = auth()->user()->name;
        $item->update($validated);

        return redirect()->back()->with('success', 'Status permohonan dokumen berhasil diperbarui.');
    }

    public function permintaanDestroy($id)
    {
        $item = PermintaanDokumenInvestor::findOrFail($id);
        $item->update(['UserDelete' => auth()->user()->name]);
        $item->delete();

        return response()->json(['status' => 200, 'message' => 'Data permohonan berhasil dihapus.']);
    }
}
