<?php

namespace App\Http\Controllers;

use App\Mail\LamaranDiterimaMail;
use App\Models\LamaranKerja;
use App\Models\LowonganKerja;
use App\Models\MasterKota;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LowonganKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LowonganKerja::withCount('getLamaran')->latest();
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
                ->addColumn('JumlahPelamar', function ($row) {
                    $jumlah = $row->getLamaran()->count();
                    $url = route('karir.pelamar', encrypt($row->id));
                    return '<a href="' . $url . '" class="btn btn-sm btn-info" title="Lihat Pelamar">
                            <i class="fa fa-users mr-1"></i> ' . $jumlah . ' Pelamar
                        </a>';
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
                ->rawColumns(['StatusBadge', 'JumlahPelamar', 'action'])
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
        $request->validate([
            'Kota' => 'required|string|max:255',
            'BatasWaktu' => 'required|date|after_or_equal:today',
            'Status' => 'required|in:Buka,Tutup',
            'translations.id.Posisi' => 'required|string|max:255',
            'translations.id.Deskripsi' => 'required|string',
            'translations.id.Kualifikasi' => 'required|string',
            'translations.en.Posisi' => 'nullable|string|max:255',
            'translations.en.Deskripsi' => 'nullable|string',
            'translations.en.Kualifikasi' => 'nullable|string',
        ], [
            'translations.id.Posisi.required' => 'Posisi (Indonesia) wajib diisi.',
            'translations.id.Deskripsi.required' => 'Deskripsi (Indonesia) wajib diisi.',
            'translations.id.Kualifikasi.required' => 'Kualifikasi (Indonesia) wajib diisi.',
            'Kota.required' => 'Kota penempatan wajib diisi.',
            'BatasWaktu.required' => 'Batas waktu wajib diisi.',
            'BatasWaktu.after_or_equal' => 'Batas waktu tidak boleh di masa lalu.',
            'Status.required' => 'Status lowongan wajib dipilih.',
        ]);
        $lowongan = LowonganKerja::create([
            'Kota' => $request->Kota,
            'Posisi' => $request->Posisi,
            'BatasWaktu' => $request->BatasWaktu,
            'Status' => $request->Status,
            'UserCreate' => auth()->user()->name,
        ]);
        $translationsData = $request->input('translations', []);
        foreach ($translationsData as $locale => $data) {
            if (!empty($data['Posisi'])) {
                $lowongan->translations()->create([
                    'Locale' => $locale,
                    'Posisi' => $data['Posisi'],
                    'Deskripsi' => $data['Deskripsi'],
                    'Kualifikasi' => $data['Kualifikasi'],
                ]);
            }
        }
        activity()
            ->causedBy(auth()->user())
            ->performedOn($lowongan)
            ->withProperties(['attributes' => $lowongan->toArray()])
            ->log('Menambah lowongan kerja: ' . $lowongan->translate('id')->Posisi);

        return redirect()->route('karir.index')->with('success', 'Lowongan kerja berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $lowongan = LowonganKerja::with('translations')->findOrFail($id);
        $Kota = MasterKota::get();
        return view('pages.admin.karir-dan-rekrutmen.edit', compact('lowongan', 'Kota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Data Utama & Terjemahan
        $request->validate([
            'Kota' => 'required|string|max:255',
            'BatasWaktu' => 'nullable|date',
            'Status' => 'required|in:Buka,Tutup',

            // Validasi Bahasa Indonesia (Wajib)
            'translations.id.Posisi' => 'required|string|max:255',
            'translations.id.Deskripsi' => 'nullable|string',
            'translations.id.Kualifikasi' => 'nullable|string',

            // Validasi Bahasa Inggris (Opsional)
            'translations.en.Posisi' => 'nullable|string|max:255',
            'translations.en.Deskripsi' => 'nullable|string',
            'translations.en.Kualifikasi' => 'nullable|string',
        ], [
            'translations.id.Posisi.required' => 'Posisi (Indonesia) wajib diisi.',
            'Kota.required' => 'Kota penempatan wajib diisi.',
            'Status.required' => 'Status lowongan wajib dipilih.',
        ]);

        $lowongan = LowonganKerja::findOrFail($id);

        // Simpan data lama untuk Activity Log
        $oldMain = $lowongan->getOriginal();
        $oldTranslations = $lowongan->translations->pluck('Posisi', 'Locale')->toArray();

        // 2. Update Data Utama (Hanya field non-translatable)
        $lowongan->update([
            'Kota' => $request->Kota,
            'BatasWaktu' => $request->BatasWaktu,
            'Status' => $request->Status,
            'UserUpdate' => auth()->user()->name,
        ]);

        // 3. Update / Create Data Terjemahan
        $translationsData = $request->input('translations', []);
        foreach ($translationsData as $locale => $data) {
            // Hanya proses jika ada input Posisi (menghindari save data kosong)
            if (!empty($data['Posisi'])) {
                $lowongan->translations()->updateOrCreate(
                    ['Locale' => $locale], // Kondisi pencarian (berdasarkan bahasa)
                    [
                        'Posisi' => $data['Posisi'] ?? null,
                        'Deskripsi' => $data['Deskripsi'] ?? null,
                        'Kualifikasi' => $data['Kualifikasi'] ?? null,
                    ]
                );
            }
        }

        // Refresh model agar data terjemahan terbaru ter-load
        $lowongan->load('translations');

        // 4. Activity Log
        $posisiBaru = $lowongan->translate('id')->Posisi; // Ambil posisi bahasa ID untuk log

        activity()
            ->causedBy(auth()->user())
            ->performedOn($lowongan)
            ->withProperties([
                'old_main' => $oldMain,
                'old_translations' => $oldTranslations,
                'attributes' => $lowongan->toArray(),
                'new_translations' => $translationsData
            ])
            ->log('Mengubah lowongan kerja: ' . $posisiBaru);

        return redirect()
            ->route('karir.index')
            ->with('success', 'Lowongan kerja berhasil diperbarui.');
    }
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
        // Ambil bahasa yang sedang aktif (default 'id' jika belum ada fitur switch language)
        $locale = app()->getLocale();

        $query = LowonganKerja::query()->with([
            'translations' => function ($q) use ($locale) {
                // Hanya load translasi sesuai bahasa yang aktif untuk menghemat memori
                $q->where('Locale', $locale);
            }
        ]);

        // Scope active (Status = 'Buka')
        $query->active();

        // Filter Kota
        if ($request->filled('kota')) {
            $query->where('Kota', $request->kota);
        }

        // Filter Search (Mencari di tabel terjemahan sesuai bahasa aktif)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('translations', function ($q) use ($search, $locale) {
                $q->where('Locale', $locale)
                    ->where(function ($subQ) use ($search) {
                        $subQ->where('Posisi', 'like', '%' . $search . '%')
                            ->orWhere('Deskripsi', 'like', '%' . $search . '%')
                            ->orWhere('Kualifikasi', 'like', '%' . $search . '%');
                    });
            });
        }

        // Sorting
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

        // Pagination
        $lowongans = $query->paginate(9)->withQueryString();

        // Stats (Tetap sama, karena tidak butuh translasi)
        $totalJobs = LowonganKerja::active()->count();
        $kotas = LowonganKerja::active()
            ->select('Kota')
            ->distinct()
            ->pluck('Kota')
            ->filter();

        return view('frontend.career', compact('lowongans', 'totalJobs', 'kotas', 'locale'));
    }

    public function careerDetail($id, $slug)
    {
        $locale = app()->getLocale();
        Carbon::setLocale($locale);
        $lowongan = LowonganKerja::with([
            'translations' => function ($q) use ($locale) {
                $q->where('Locale', $locale);
            }
        ])->findOrFail($id);

        return view('frontend.career-detail', compact('lowongan', 'locale'));
    }

    public function apply(Request $request, $id)
    {
        $request->validate([
            'NamaLengkap' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'NoHp' => 'required|string|max:20',
            'EkspetasiGaji' => 'required|string|max:100',
            'DeskripsiSingkat' => 'required|string|max:1000',
            'PathCv' => 'required|file|mimes:pdf|max:2048',
        ], [
            'PathCv.mimes' => 'File CV harus berformat PDF.',
            'PathCv.max' => 'Ukuran file CV maksimal 2MB.',
        ]);

        $file = $request->file('PathCv');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('cv_lamaran', $fileName, 'public');

        $lamaran = LamaranKerja::create([
            'LowonganKerjaId' => $id,
            'NamaLengkap' => $request->NamaLengkap,
            'Email' => $request->Email,
            'NoHp' => $request->NoHp,
            'PathCv' => str_replace('public/', '', $filePath),
            'EkspetasiGaji' => preg_replace('/\D/', '', $request->EkspetasiGaji),
            'DeskripsiSingkat' => $request->DeskripsiSingkat,
            'Status' => 'Menunggu'
        ]);

        $lowongan = LowonganKerja::find($id);
        try {
            Mail::to($lamaran->Email)->send(new LamaranDiterimaMail($lamaran, $lowongan));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email konfirmasi lamaran: ' . $e->getMessage());
        }
        // try {
        //     $adminEmail = config('mail.admin_email', 'hr@company.com');
        //     Mail::to($adminEmail)->send(new \App\Mail\LamaranBaruNotificationMail($lamaran, $lowongan));
        // } catch (\Exception $e) {
        //     \Log::error('Gagal mengirim notifikasi ke admin: ' . $e->getMessage());
        // }

        return redirect()->back()->with('success', 'Lamaran Anda berhasil dikirim! Kami telah mengirim konfirmasi ke email Anda.');
    }
    public function pelamar(Request $request, $id)
    {
        $lowongan = LowonganKerja::find(decrypt($id));

        if (!$lowongan) {
            return redirect()->route('karir.index')->with('error', 'Lowongan tidak ditemukan');
        }

        if ($request->ajax()) {
            $data = LamaranKerja::where('LowonganKerjaId', $lowongan->id)->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('EmailLink', function ($row) {
                    return '<a href="mailto:' . $row->Email . '" class="text-primary" title="Kirim Email">
                            <i class="fa fa-envelope mr-1"></i>' . $row->Email . '
                        </a>';
                })
                ->addColumn('NoHpLink', function ($row) {
                    // Konversi format nomor ke WhatsApp (08xxx -> 62xxx)
                    $waNumber = preg_replace('/^0/', '62', $row->NoHp);
                    $waNumber = preg_replace('/[^0-9]/', '', $waNumber);

                    return '<a href="https://wa.me/' . $waNumber . '" target="_blank" class="text-success" title="Chat WhatsApp">
                            <i class="fab fa-whatsapp mr-1"></i>' . $row->NoHp . '
                        </a>';
                })
                ->addColumn('EkspetasiGajiFormatted', function ($row) {
                    return $row->EkspetasiGaji
                        ? 'Rp ' . number_format($row->EkspetasiGaji, 0, ',', '.')
                        : '-';
                })
                ->addColumn('TanggalLamar', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('d M Y H:i');
                })
                ->addColumn('StatusDropdown', function ($row) {
                    $status = $row->Status ?? 'Menunggu';
                    $badgeClass = [
                        'Menunggu' => 'badge-warning',
                        'Diterima' => 'badge-success',
                        'Ditolak' => 'badge-danger'
                    ][$status] ?? 'badge-secondary';

                    return '
                    <select class="form-control form-control-sm change-status"
                            data-id="' . $row->id . '"
                            style="width: auto; display: inline-block;">
                        <option value="Menunggu" ' . ($status == 'Menunggu' ? 'selected' : '') . '>Menunggu</option>
                        <option value="Diterima" ' . ($status == 'Diterima' ? 'selected' : '') . '>Diterima</option>
                        <option value="Ditolak" ' . ($status == 'Ditolak' ? 'selected' : '') . '>Ditolak</option>
                    </select>
                    <span class="badge ' . $badgeClass . ' ml-2">' . $status . '</span>
                ';
                })
                ->addColumn('CV', function ($row) {
                    if ($row->PathCv && file_exists(public_path('storage/' . $row->PathCv))) {
                        return '<a href="' . asset('storage/' . $row->PathCv) . '" target="_blank" class="btn btn-sm btn-secondary" title="Download CV">
                                <i class="fa fa-file-pdf"></i> CV
                            </a>';
                    }
                    return '<span class="text-muted">-</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-sm btn-info btn-detail"
                            data-nama="' . $row->NamaLengkap . '"
                            data-email="' . $row->Email . '"
                            data-hp="' . $row->NoHp . '"
                            data-gaji="' . ($row->EkspetasiGaji ? "Rp " . number_format($row->EkspetasiGaji, 0, ",", ".") : "-") . '"
                            data-deskripsi="' . htmlspecialchars($row->DeskripsiSingkat ?? "-") . '"
                            data-cv="' . ($row->PathCv ? asset($row->PathCv) : "") . '"
                            data-status="' . ($row->Status ?? "Menunggu") . '"
                            data-tanggal="' . \Carbon\Carbon::parse($row->created_at)->format("d M Y H:i") . '"
                            title="Detail">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                ';
                })
                ->rawColumns(['StatusDropdown', 'CV', 'action', 'EmailLink', 'NoHpLink'])
                ->make(true);
        }

        return view('pages.admin.karir-dan-rekrutmen.pelamar', compact('lowongan'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'Status' => 'required|in:Menunggu,Diterima,Ditolak'
        ]);

        $lamaran = LamaranKerja::find($id);

        if (!$lamaran) {
            return response()->json([
                'status' => 404,
                'message' => 'Data pelamar tidak ditemukan'
            ], 404);
        }

        $oldStatus = $lamaran->Status;

        $lamaran->Status = $request->Status;
        $lamaran->save();

        // Tambah activity log untuk update status lamaran
        activity()
            ->causedBy(auth()->user())
            ->performedOn($lamaran)
            ->withProperties([
                'old' => ['Status' => $oldStatus],
                'attributes' => ['Status' => $lamaran->Status]
            ])
            ->log('Mengubah status lamaran kerja menjadi: ' . $lamaran->Status);

        return response()->json([
            'status' => 200,
            'message' => 'Status berhasil diubah menjadi ' . $request->Status
        ]);
    }
}
