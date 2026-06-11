<?php

namespace App\Http\Controllers;

use App\Models\LamaranKerja;
use App\Models\LowonganKerja;
use App\Models\MasterKota;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class LowonganKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LowonganKerja::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('StatusBadge', function ($row) {
                    if ($row->Status === 'Buka') {
                        return '<span class="badge badge-success">Buka</span>';
                    }
                    return '<span class="badge badge-danger">Tutup</span>';
                })
                ->addColumn('BatasWaktuFormatted', function ($row) {
                    return $row->BatasWaktu
                        ? \Carbon\Carbon::parse($row->BatasWaktu)->format('d M Y')
                        : '-';
                })
                ->addColumn('DeskripsiSingkat', function ($row) {
                    return Str::limit(strip_tags($row->Deskripsi ?? ''), 50, '...');
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group btn-group-sm">
                            <a href="' . route('karir.edit', encrypt($row->id)) . '" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>

                            <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['StatusBadge', 'action'])
                ->make(true);
        }

        return view('pages.admin.karir-dan-rekrutmen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Kota = MasterKota::get();
        return view('pages.admin.karir-dan-rekrutmen.create', compact('Kota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'Posisi' => 'required|string|max:255',
            'Kota' => 'required|string|max:255',
            'Deskripsi' => 'required|string',
            'Kualifikasi' => 'required|string',
            'BatasWaktu' => 'required|date|after_or_equal:today',
            'Status' => 'required|in:Buka,Tutup',
        ], [
            'Posisi.required' => 'Posisi wajib diisi.',
            'Kota.required' => 'Kota penempatan wajib diisi.',
            'Deskripsi.required' => 'Deskripsi pekerjaan wajib diisi.',
            'Kualifikasi.required' => 'Kualifikasi kandidat wajib diisi.',
            'BatasWaktu.required' => 'Batas waktu wajib diisi.',
            'BatasWaktu.after_or_equal' => 'Batas waktu tidak boleh di masa lalu.',
            'Status.required' => 'Status lowongan wajib dipilih.',
        ]);

        LowonganKerja::create([
            'Posisi' => $request->Posisi,
            'Kota' => $request->Kota,
            'Deskripsi' => $request->Deskripsi,
            'Kualifikasi' => $request->Kualifikasi,
            'BatasWaktu' => $request->BatasWaktu,
            'Status' => $request->Status,
            'UserCreate' => auth()->user()->name,
        ]);

        return redirect()
            ->route('karir.index')
            ->with('success', 'Lowongan kerja berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $lowongan = LowonganKerja::findOrFail($id);
        $Kota = MasterKota::get();
        return view('pages.admin.karir-dan-rekrutmen.edit', compact('lowongan', 'Kota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Posisi' => 'required|string|max:255',
            'Kota' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
            'Kualifikasi' => 'nullable|string',
            'BatasWaktu' => 'nullable|date',
            'Status' => 'required|in:Buka,Tutup',
        ], [
            'Posisi.required' => 'Posisi wajib diisi.',
            'Kota.required' => 'Kota penempatan wajib diisi.',
            'Status.required' => 'Status lowongan wajib dipilih.',
        ]);

        $lowongan = LowonganKerja::findOrFail($id);
        $lowongan->update([
            'Posisi' => $request->Posisi,
            'Kota' => $request->Kota,
            'Deskripsi' => $request->Deskripsi,
            'Kualifikasi' => $request->Kualifikasi,
            'BatasWaktu' => $request->BatasWaktu,
            'Status' => $request->Status,
            'UserUpdate' => auth()->user()->name,
        ]);

        return redirect()
            ->route('karir.index')
            ->with('success', 'Lowongan kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy($id)
    {
        $lowongan = LowonganKerja::find($id);

        if (!$lowongan) {
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        // Catat siapa yang menghapus sebelum soft delete
        $lowongan->update(['UserDelete' => auth()->user()->name]);
        $lowongan->delete();  // Soft delete

        return response()->json([
            'status' => 200,
            'message' => 'Lowongan kerja berhasil dihapus'
        ]);
    }

    public function career(Request $request)
    {
        $query = LowonganKerja::query();
        $query->active();
        if ($request->filled('kota')) {
            $query->where('Kota', $request->kota);
        }
        if ($request->filled('status')) {
            $query->where('Status', $request->status);
            $query->withoutGlobalScope('active');  // kalau pakai global scope
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('Posisi', 'like', '%' . $search . '%')
                    ->orWhere('Deskripsi', 'like', '%' . $search . '%')
                    ->orWhere('Kualifikasi', 'like', '%' . $search . '%');
            });
        }
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'deadline':
                $query->orderBy('BatasWaktu', 'asc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }
        $lowongans = $query->paginate(9)->withQueryString();
        $totalJobs = LowonganKerja::active()->count();
        $kotas = LowonganKerja::active()
            ->select('Kota')
            ->distinct()
            ->pluck('Kota')
            ->filter();

        return view('frontend.career', compact('lowongans', 'totalJobs', 'kotas'));
    }

    public function careerDetail($id, $slug)
    {
        $lowongan = LowonganKerja::findOrFail($id);
        return view('frontend.career-detail', compact('lowongan'));
    }

    public function apply(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'NoHp' => 'required|string|max:20',
            'EkspetasiGaji' => 'required|string|max:100',
            'DeskripsiSingkat' => 'required|string|max:1000',
            'PathCv' => 'required|file|mimes:pdf|max:3072',
        ], [
            'PathCv.mimes' => 'File CV harus berformat PDF.',
            'PathCv.max' => 'Ukuran file CV maksimal 3MB.',
        ]);

        $file = $request->file('PathCv');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('public/cv_lamaran', $fileName);

        LamaranKerja::create([
            'LowonganKerjaId' => $id,
            'NamaLengkap' => $request->NamaLengkap,
            'Email' => $request->Email,
            'NoHp' => $request->NoHp,
            'PathCv' => str_replace('public/', '', $filePath),
            'EkspetasiGaji' => preg_replace('/\D/', '', $request->EkspetasiGaji),
            'DeskripsiSingkat' => $request->DeskripsiSingkat,
            'Status' => 'Menunggu'
        ]);

        return redirect()->back()->with('success', 'Lamaran Anda berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}
