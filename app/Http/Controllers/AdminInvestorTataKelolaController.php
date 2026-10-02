<?php

namespace App\Http\Controllers;

use App\Models\BaganOrganisasi;
use App\Models\ManajemenTataKelola;
use App\Models\DokumenTataKelola;
use App\Models\RupsDokumen;
use App\Models\WbsLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminInvestorTataKelolaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:investor.view')->only(['index', 'wbsIndex', 'wbsShow']);
        $this->middleware('permission:investor.create')->only(['storeManajemen', 'storeDokumen', 'storeRups']);
        $this->middleware('permission:investor.edit')->only(['updateBagan', 'updateManajemen', 'updateDokumen', 'updateRups', 'wbsUpdateStatus']);
        $this->middleware('permission:investor.delete')->only(['destroyManajemen', 'destroyDokumen', 'destroyRups']);
    }

    public function index()
    {
        $bagan = BaganOrganisasi::first() ?? new BaganOrganisasi();
        $manajemenList = ManajemenTataKelola::orderBy('Kategori')->orderBy('Urutan')->get();
        $dokumenList = DokumenTataKelola::orderBy('Kategori')->orderBy('Urutan')->get();
        $rupsList = RupsDokumen::orderBy('Tahun', 'desc')->orderBy('Urutan')->get();

        return view('master.investor.tata-kelola.index', compact('bagan', 'manajemenList', 'dokumenList', 'rupsList'));
    }

    // --- 1. Update Bagan Organisasi & Sekretariat ---
    public function updateBagan(Request $request)
    {
        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'TanggalDiperbarui' => 'nullable|date',
            'Keterangan' => 'nullable|string',
            'EmailSekretariat' => 'required|email|max:255',
            'TeleponSekretariat' => 'required|string|max:50',
            'AlamatSekretariat' => 'nullable|string',
            'GambarBagan' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'FileBaganPdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $bagan = BaganOrganisasi::first() ?? new BaganOrganisasi();

        if ($request->hasFile('GambarBagan')) {
            if ($bagan->PathGambar && Storage::disk('public')->exists($bagan->PathGambar)) {
                Storage::disk('public')->delete($bagan->PathGambar);
            }
            $validated['PathGambar'] = $request->file('GambarBagan')->store('investor/bagan', 'public');
        }

        if ($request->hasFile('FileBaganPdf')) {
            if ($bagan->PathFilePdf && Storage::disk('public')->exists($bagan->PathFilePdf)) {
                Storage::disk('public')->delete($bagan->PathFilePdf);
            }
            $validated['PathFilePdf'] = $request->file('FileBaganPdf')->store('investor/bagan', 'public');
        }

        $validated['UserUpdate'] = auth()->user()->name;

        if ($bagan->exists) {
            $bagan->update($validated);
        } else {
            $validated['UserCreate'] = auth()->user()->name;
            BaganOrganisasi::create($validated);
        }

        return redirect()->back()->with('success', 'Bagan organisasi dan informasi sekretariat berhasil diperbarui.');
    }

    // --- 2. CRUD Manajemen Perseroan ---
    public function storeManajemen(Request $request)
    {
        $validated = $request->validate([
            'Nama' => 'required|string|max:255',
            'Jabatan' => 'required|string|max:255',
            'Kategori' => 'required|in:Dewan Komisaris,Direksi Perseroan',
            'Foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'DeskripsiSingkat' => 'nullable|string',
            'ProfilLengkap' => 'nullable|string',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('Foto')) {
            $validated['Foto'] = $request->file('Foto')->store('investor/manajemen', 'public');
        }

        $validated['UserCreate'] = auth()->user()->name;
        ManajemenTataKelola::create($validated);

        return redirect()->back()->with('success', 'Anggota manajemen berhasil ditambahkan.');
    }

    public function updateManajemen(Request $request, $id)
    {
        $person = ManajemenTataKelola::findOrFail($id);

        $validated = $request->validate([
            'Nama' => 'required|string|max:255',
            'Jabatan' => 'required|string|max:255',
            'Kategori' => 'required|in:Dewan Komisaris,Direksi Perseroan',
            'Foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'DeskripsiSingkat' => 'nullable|string',
            'ProfilLengkap' => 'nullable|string',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('Foto')) {
            if ($person->Foto && Storage::disk('public')->exists($person->Foto)) {
                Storage::disk('public')->delete($person->Foto);
            }
            $validated['Foto'] = $request->file('Foto')->store('investor/manajemen', 'public');
        }

        $validated['UserUpdate'] = auth()->user()->name;
        $person->update($validated);

        return redirect()->back()->with('success', 'Data manajemen berhasil diperbarui.');
    }

    public function destroyManajemen($id)
    {
        $person = ManajemenTataKelola::findOrFail($id);
        if ($person->Foto && Storage::disk('public')->exists($person->Foto)) {
            Storage::disk('public')->delete($person->Foto);
        }
        $person->update(['UserDelete' => auth()->user()->name]);
        $person->delete();

        return response()->json(['status' => 200, 'message' => 'Anggota manajemen berhasil dihapus.']);
    }

    // --- 3. CRUD Dokumen Tata Kelola & Kebijakan ---
    public function storeDokumen(Request $request)
    {
        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'Kategori' => 'required|in:Dokumen Tata Kelola,Kebijakan Operasional,Komite Audit,Satuan Audit Internal',
            'Deskripsi' => 'nullable|string',
            'FileDokumen' => 'nullable|file|mimes:pdf,docx,xlsx|max:10240',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('FileDokumen')) {
            $file = $request->file('FileDokumen');
            $validated['PathFile'] = $file->store('investor/dokumen-gcg', 'public');
            $validated['FileSize'] = round($file->getSize() / 1024 / 1024, 2) . ' MB';
        }

        $validated['UserCreate'] = auth()->user()->name;
        DokumenTataKelola::create($validated);

        return redirect()->back()->with('success', 'Dokumen tata kelola berhasil ditambahkan.');
    }

    public function updateDokumen(Request $request, $id)
    {
        $doc = DokumenTataKelola::findOrFail($id);

        $validated = $request->validate([
            'Judul' => 'required|string|max:255',
            'Kategori' => 'required|in:Dokumen Tata Kelola,Kebijakan Operasional,Komite Audit,Satuan Audit Internal',
            'Deskripsi' => 'nullable|string',
            'FileDokumen' => 'nullable|file|mimes:pdf,docx,xlsx|max:10240',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('FileDokumen')) {
            if ($doc->PathFile && Storage::disk('public')->exists($doc->PathFile)) {
                Storage::disk('public')->delete($doc->PathFile);
            }
            $file = $request->file('FileDokumen');
            $validated['PathFile'] = $file->store('investor/dokumen-gcg', 'public');
            $validated['FileSize'] = round($file->getSize() / 1024 / 1024, 2) . ' MB';
        }

        $validated['UserUpdate'] = auth()->user()->name;
        $doc->update($validated);

        return redirect()->back()->with('success', 'Dokumen tata kelola berhasil diperbarui.');
    }

    public function destroyDokumen($id)
    {
        $doc = DokumenTataKelola::findOrFail($id);
        if ($doc->PathFile && Storage::disk('public')->exists($doc->PathFile)) {
            Storage::disk('public')->delete($doc->PathFile);
        }
        $doc->update(['UserDelete' => auth()->user()->name]);
        $doc->delete();

        return response()->json(['status' => 200, 'message' => 'Dokumen berhasil dihapus.']);
    }

    // --- 4. CRUD Dokumen RUPS ---
    public function storeRups(Request $request)
    {
        $validated = $request->validate([
            'Tahun' => 'required|integer|min:2000|max:2099',
            'Judul' => 'required|string|max:255',
            'KategoriDokumen' => 'nullable|string|max:100',
            'StatusKegiatan' => 'required|in:Terjadwal,Selesai',
            'FileDokumen' => 'nullable|file|mimes:pdf|max:10240',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('FileDokumen')) {
            $file = $request->file('FileDokumen');
            $validated['PathFile'] = $file->store('investor/rups', 'public');
            $validated['FileSize'] = round($file->getSize() / 1024 / 1024, 2) . ' MB';
        }

        $validated['UserCreate'] = auth()->user()->name;
        RupsDokumen::create($validated);

        return redirect()->back()->with('success', 'Dokumen RUPS berhasil ditambahkan.');
    }

    public function updateRups(Request $request, $id)
    {
        $rups = RupsDokumen::findOrFail($id);

        $validated = $request->validate([
            'Tahun' => 'required|integer|min:2000|max:2099',
            'Judul' => 'required|string|max:255',
            'KategoriDokumen' => 'nullable|string|max:100',
            'StatusKegiatan' => 'required|in:Terjadwal,Selesai',
            'FileDokumen' => 'nullable|file|mimes:pdf|max:10240',
            'Urutan' => 'nullable|integer|min:0',
            'Status' => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->hasFile('FileDokumen')) {
            if ($rups->PathFile && Storage::disk('public')->exists($rups->PathFile)) {
                Storage::disk('public')->delete($rups->PathFile);
            }
            $file = $request->file('FileDokumen');
            $validated['PathFile'] = $file->store('investor/rups', 'public');
            $validated['FileSize'] = round($file->getSize() / 1024 / 1024, 2) . ' MB';
        }

        $validated['UserUpdate'] = auth()->user()->name;
        $rups->update($validated);

        return redirect()->back()->with('success', 'Dokumen RUPS berhasil diperbarui.');
    }

    public function destroyRups($id)
    {
        $rups = RupsDokumen::findOrFail($id);
        if ($rups->PathFile && Storage::disk('public')->exists($rups->PathFile)) {
            Storage::disk('public')->delete($rups->PathFile);
        }
        $rups->update(['UserDelete' => auth()->user()->name]);
        $rups->delete();

        return response()->json(['status' => 200, 'message' => 'Dokumen RUPS berhasil dihapus.']);
    }

    // --- 5. Monitoring Laporan WBS Masuk ---
    public function wbsIndex()
    {
        $laporanList = WbsLaporan::orderBy('created_at', 'desc')->get();
        return view('master.investor.tata-kelola.wbs-index', compact('laporanList'));
    }

    public function wbsShow($id)
    {
        $laporan = WbsLaporan::findOrFail($id);
        return view('master.investor.tata-kelola.wbs-show', compact('laporan'));
    }

    public function wbsUpdateStatus(Request $request, $id)
    {
        $laporan = WbsLaporan::findOrFail($id);
        $validated = $request->validate([
            'StatusLaporan' => 'required|in:Menunggu Review,Sedang Diproses,Selesai,Ditolak',
            'CatatanTindakLanjut' => 'nullable|string',
        ]);

        $validated['UserUpdate'] = auth()->user()->name;
        $laporan->update($validated);

        return redirect()->back()->with('success', 'Status laporan WBS berhasil diperbarui.');
    }
}
