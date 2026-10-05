<?php
namespace App\Http\Controllers;

use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class WhyChooseUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:homepage.view')->only(['index']);
        $this->middleware('permission:homepage.create')->only(['create', 'store']);
        $this->middleware('permission:homepage.edit')->only(['edit', 'update']);
        $this->middleware('permission:homepage.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WhyChooseUs::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->Status
                        ? '<span class="badge badge-success px-2 py-1">Aktif</span>'
                        : '<span class="badge badge-secondary px-2 py-1">Tidak Aktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';
                    if (auth()->user()->can('homepage.edit')) {
                        $btn .= '<a href="' . route('why-choose-us.edit', $row->id) . '" class="btn btn-warning" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>';
                    }
                    if (auth()->user()->can('homepage.delete')) {
                        $btn .= '<button class="btn btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('Icon', function ($row) {
                    if ($row->Icon) {
                        $url = asset('storage/' . $row->Icon);
                        return '<img src="' . $url . '" alt="Icon" style="height:40px;">';
                    } else {
                        return '<span class="text-muted">-</span>';
                    }
                })

                ->rawColumns(['status', 'action', 'Icon'])
                ->make(true);
        }

        return view('pages.admin.why-choose-us.index');
    }

    public function create()
    {
        return view('pages.admin.why-choose-us.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Icon' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'Urutan' => 'required|integer|min:0',
            'Status' => 'required|boolean',

            // Translations
            'translations.id.Judul' => 'required|string|max:255',
            'translations.id.Deskripsi' => 'required|string',
            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.Deskripsi' => 'nullable|string',
        ]);

        $iconPath = $request->file('Icon')->store('why-choose-us/icons', 'public');

        $mainData = [
            'Icon' => $iconPath,
            'Urutan' => $request->Urutan,
            'Status' => $request->Status,
        ];

        $item = WhyChooseUs::create($mainData);

        // Simpan terjemahan
        $translationsData = [];
        foreach (['id', 'en'] as $locale) {
            if (!empty($validated['translations'][$locale]['Judul'])) {
                $translation = [
                    'Locale' => $locale,
                    'Judul' => $validated['translations'][$locale]['Judul'] ?? null,
                    'Deskripsi' => $validated['translations'][$locale]['Deskripsi'] ?? null,
                ];
                $item->translations()->create($translation);
                $translationsData[$locale] = $translation;
            }
        }

        // Logging activity untuk store
        activity()
            ->causedBy(auth()->user())
            ->performedOn($item)
            ->withProperties([
                'attributes' => $mainData,
                'translations' => $translationsData
            ])
            ->log('Membuat data keunggulan: ' . ($validated['translations']['id']['Judul'] ?? ''));

        return redirect()->route('why-choose-us.index')->with('success', 'Data keunggulan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = WhyChooseUs::findOrFail($id);
        return view('pages.admin.why-choose-us.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'Icon' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'Urutan' => 'required|integer|min:0',
            'Status' => 'required|boolean',

            // Translations
            'translations.id.Judul' => 'required|string|max:255',
            'translations.id.Deskripsi' => 'required|string',
            'translations.en.Judul' => 'nullable|string|max:255',
            'translations.en.Deskripsi' => 'nullable|string',
        ]);

        $item = WhyChooseUs::findOrFail($id);

        // Handle Icon Update
        if ($request->hasFile('Icon')) {
            if ($item->Icon && \Storage::disk('public')->exists($item->Icon)) {
                \Storage::disk('public')->delete($item->Icon);
            }
            $item->Icon = $request->file('Icon')->store('why-choose-us/icons', 'public');
        }

        $mainData = [
            'Urutan' => $request->Urutan,
            'Status' => $request->Status,
            'Icon' => $item->Icon, // ambil icon yang baru jika diupdate, atau lama jika tidak
        ];

        $item->update([
            'Urutan' => $request->Urutan,
            'Status' => $request->Status,
        ]);

        // Update/Create Translations
        $translationsData = [];
        foreach (['id', 'en'] as $locale) {
            $trans = [
                'Judul' => $validated['translations'][$locale]['Judul'] ?? null,
                'Deskripsi' => $validated['translations'][$locale]['Deskripsi'] ?? null,
            ];
            $item->translations()->updateOrCreate(
                ['Locale' => $locale],
                $trans
            );
            $translationsData[$locale] = $trans;
        }

        // Logging activity untuk update
        activity()
            ->causedBy(auth()->user())
            ->performedOn($item)
            ->withProperties([
                'attributes' => $mainData,
                'translations' => $translationsData
            ])
            ->log('Mengupdate data keunggulan: ' . ($validated['translations']['id']['Judul'] ?? ''));

        return redirect()->route('why-choose-us.index')->with('success', 'Data keunggulan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $item = WhyChooseUs::findOrFail($id);

            // Hapus file icon dari storage
            if ($item->Icon && Storage::disk('public')->exists($item->Icon)) {
                Storage::disk('public')->delete($item->Icon);
            }

            // Untuk logging, ambil data sebelum dihapus
            $mainData = [
                'Icon' => $item->Icon,
                'Urutan' => $item->Urutan,
                'Status' => $item->Status,
            ];
            $translationsData = [];
            foreach ($item->translations as $trans) {
                $translationsData[$trans->Locale] = [
                    'Judul' => $trans->Judul,
                    'Deskripsi' => $trans->Deskripsi,
                ];
            }

            $item->delete();

            // Logging activity untuk delete
            activity()
                ->causedBy(auth()->user())
                ->performedOn($item)
                ->withProperties([
                    'attributes' => $mainData,
                    'translations' => $translationsData
                ])
                ->log('Menghapus data keunggulan: ' . ($translationsData['id']['Judul'] ?? 'tidak diketahui'));

            return response()->json(['message' => 'Data berhasil dihapus!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data.'], 500);
        }
    }
}
