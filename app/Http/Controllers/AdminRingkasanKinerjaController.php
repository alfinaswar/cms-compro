<?php

namespace App\Http\Controllers;

use App\Models\RingkasanKinerjaPos;
use App\Models\RingkasanKinerjaNilai;
use App\Models\PengaturanKinerjaKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminRingkasanKinerjaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:investor.view')->only(['index']);
        $this->middleware('permission:investor.create')->only(['store', 'tambahTahun']);
        $this->middleware('permission:investor.edit')->only(['update', 'updatePeriode', 'quickUpdateBatch']);
        $this->middleware('permission:investor.delete')->only(['destroy', 'hapusTahun']);
    }

    public function index()
    {
        $pengaturan = PengaturanKinerjaKeuangan::firstOrCreate(
            ['id' => 1],
            [
                'ModeWindow' => 'Kustom',
                'JumlahTahun' => 5,
                'TahunMulai' => 2021,
                'TahunSelesai' => 2025,
                'PertumbuhanRevenue' => '+31.5% YoY (2025)',
                'PertumbuhanProfit' => '+47.7% YoY (2025)',
                'Subjudul' => 'Ringkasan kinerja keuangan utama perusahaan selama 5 tahun terakhir (2021 - 2025).',
                'UserCreate' => 'System',
            ]
        );

        $activeYears = $pengaturan->getActiveYears();
        $allYears = $pengaturan->getAllYears();

        $allRows = RingkasanKinerjaPos::with('nilais')->orderBy('Urutan', 'asc')->get();

        $labaRugi = $allRows->where('Kategori', 'Laba Rugi');
        $posisiKeuangan = $allRows->where('Kategori', 'Posisi Keuangan');
        $rasioKeuangan = $allRows->where('Kategori', 'Rasio');
        $sahamDividen = $allRows->where('Kategori', 'Saham & Dividen');

        return view('master.investor.ringkasan-kinerja.index', compact(
            'pengaturan',
            'activeYears',
            'allYears',
            'labaRugi',
            'posisiKeuangan',
            'rasioKeuangan',
            'sahamDividen',
            'allRows'
        ));
    }

    public function updatePeriode(Request $request)
    {
        $validated = $request->validate([
            'ModeWindow' => 'required|in:Otomatis,Kustom',
            'JumlahTahun' => 'required|integer|min:1|max:20',
            'TahunMulai' => 'required|integer|min:1990|max:2100',
            'TahunSelesai' => 'required|integer|min:1990|max:2100|gte:TahunMulai',
            'PertumbuhanRevenue' => 'nullable|string|max:100',
            'PertumbuhanProfit' => 'nullable|string|max:100',
            'Subjudul' => 'nullable|string|max:255',
        ]);

        $validated['UserUpdate'] = auth()->user()->name ?? 'Administrator';

        $pengaturan = PengaturanKinerjaKeuangan::first();
        if ($pengaturan) {
            $pengaturan->update($validated);
        } else {
            $validated['UserCreate'] = auth()->user()->name ?? 'Administrator';
            PengaturanKinerjaKeuangan::create($validated);
        }

        return redirect()->back()->with('success', 'Pengaturan Periode Tahun & Pertumbuhan berhasil disimpan!');
    }

    public function tambahTahun(Request $request)
    {
        $request->validate([
            'Tahun' => 'required|integer|min:1990|max:2100',
        ]);

        $tahunBaru = (int) $request->input('Tahun');
        $userName = auth()->user()->name ?? 'Administrator';

        // Pastikan setiap pos yang ada terdaftar di tahun baru ini
        $allPos = RingkasanKinerjaPos::all();
        foreach ($allPos as $pos) {
            RingkasanKinerjaNilai::firstOrCreate(
                ['PosId' => $pos->id, 'Tahun' => $tahunBaru],
                ['NilaiTampil' => '-', 'NilaiAngka' => null, 'UserCreate' => $userName]
            );
        }

        // Jika opsi geser periode dicentang atau tahun baru lebih besar dari TahunSelesai
        $pengaturan = PengaturanKinerjaKeuangan::first();
        if ($pengaturan) {
            if ($request->has('SetSebagaiTahunTerbaru') || $tahunBaru > $pengaturan->TahunSelesai) {
                $jumlahTahun = $pengaturan->JumlahTahun ?: 5;
                $pengaturan->update([
                    'TahunSelesai' => $tahunBaru,
                    'TahunMulai' => $tahunBaru - $jumlahTahun + 1,
                    'UserUpdate' => $userName,
                ]);
            }
        }

        return redirect()->back()->with('success', "Tahun $tahunBaru berhasil ditambahkan ke dalam sistem!");
    }

    public function hapusTahun(Request $request)
    {
        $request->validate([
            'Tahun' => 'required|integer',
        ]);

        $tahun = (int) $request->input('Tahun');
        RingkasanKinerjaNilai::where('Tahun', $tahun)->delete();

        return redirect()->back()->with('success', "Seluruh data kinerja untuk Tahun $tahun berhasil dihapus.");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Kategori' => 'required|string|in:Laba Rugi,Posisi Keuangan,Rasio,Saham & Dividen',
            'NamaPos' => 'required|string|max:255',
            'KodePos' => 'nullable|string|max:100',
            'Catatan' => 'nullable|string|max:255',
            'Satuan' => 'nullable|string|max:50',
            'Urutan' => 'nullable|integer',
            'nilais' => 'nullable|array',
        ]);

        $validated['IsSubPos'] = $request->has('IsSubPos');
        $validated['IsBold'] = $request->has('IsBold');
        $validated['IsHighlight'] = $request->has('IsHighlight');
        $validated['Urutan'] = $request->input('Urutan', 0);
        $validated['Satuan'] = $request->input('Satuan', 'Jutaan IDR');
        $validated['KodePos'] = $request->input('KodePos') ?: Str::slug($request->input('NamaPos'), '_');
        $validated['UserCreate'] = auth()->user()->name ?? 'Administrator';

        $pos = RingkasanKinerjaPos::create($validated);

        if ($request->has('nilais') && is_array($request->input('nilais'))) {
            foreach ($request->input('nilais') as $yr => $valStr) {
                RingkasanKinerjaNilai::updateOrCreate(
                    ['PosId' => $pos->id, 'Tahun' => (int) $yr],
                    ['NilaiTampil' => $valStr, 'UserCreate' => $validated['UserCreate']]
                );
            }
        }

        return redirect()->back()->with('success', 'Baris Pos Keuangan "' . $pos->NamaPos . '" berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pos = RingkasanKinerjaPos::findOrFail($id);

        $validated = $request->validate([
            'Kategori' => 'required|string|in:Laba Rugi,Posisi Keuangan,Rasio,Saham & Dividen',
            'NamaPos' => 'required|string|max:255',
            'KodePos' => 'nullable|string|max:100',
            'Catatan' => 'nullable|string|max:255',
            'Satuan' => 'nullable|string|max:50',
            'Urutan' => 'nullable|integer',
            'nilais' => 'nullable|array',
        ]);

        $validated['IsSubPos'] = $request->has('IsSubPos');
        $validated['IsBold'] = $request->has('IsBold');
        $validated['IsHighlight'] = $request->has('IsHighlight');
        $validated['Urutan'] = $request->input('Urutan', $pos->Urutan);
        $validated['Satuan'] = $request->input('Satuan', $pos->Satuan ?? 'Jutaan IDR');
        $validated['UserUpdate'] = auth()->user()->name ?? 'Administrator';

        $pos->update($validated);

        if ($request->has('nilais') && is_array($request->input('nilais'))) {
            foreach ($request->input('nilais') as $yr => $valStr) {
                RingkasanKinerjaNilai::updateOrCreate(
                    ['PosId' => $pos->id, 'Tahun' => (int) $yr],
                    ['NilaiTampil' => $valStr, 'UserUpdate' => $validated['UserUpdate']]
                );
            }
        }

        return redirect()->back()->with('success', 'Pos Keuangan "' . $pos->NamaPos . '" berhasil diperbarui!');
    }

    public function quickUpdateBatch(Request $request)
    {
        $rowsData = $request->input('rows', []);
        $userName = auth()->user()->name ?? 'Administrator';

        foreach ($rowsData as $posId => $values) {
            $pos = RingkasanKinerjaPos::find($posId);
            if ($pos) {
                $pos->update([
                    'NamaPos' => $values['NamaPos'] ?? $pos->NamaPos,
                    'Urutan' => $values['Urutan'] ?? $pos->Urutan,
                    'UserUpdate' => $userName,
                ]);

                if (isset($values['nilais']) && is_array($values['nilais'])) {
                    foreach ($values['nilais'] as $yr => $valStr) {
                        RingkasanKinerjaNilai::updateOrCreate(
                            ['PosId' => $pos->id, 'Tahun' => (int) $yr],
                            ['NilaiTampil' => $valStr, 'UserUpdate' => $userName]
                        );
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Seluruh data Ringkasan Kinerja Keuangan berhasil diperbarui secara massal!');
    }

    public function destroy($id)
    {
        $pos = RingkasanKinerjaPos::findOrFail($id);
        $pos->update(['UserDelete' => auth()->user()->name ?? 'Administrator']);
        $pos->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Pos Keuangan "' . $pos->NamaPos . '" berhasil dihapus.'
        ]);
    }
}
