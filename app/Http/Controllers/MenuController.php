<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil menu dengan hierarki
            $data = Menu::with('translations', 'parent', 'children')
                ->orderBy('ParentId')
                ->orderBy('Urutan', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('MenuNameDisplay', function ($row) {
                    $idTrans = $row->translations->firstWhere('Locale', 'id');
                    $enTrans = $row->translations->firstWhere('Locale', 'en');

                    $namaId = $idTrans ? $idTrans->NamaMenu : $row->NamaMenu;
                    $namaEn = $enTrans ? $enTrans->NamaMenu : '';

                    $icon = $row->Icon
                        ? '<i class="' . $row->Icon . ' mr-2 text-primary"></i>'
                        : '<i class="fa fa-circle mr-2 text-muted" style="font-size:8px;"></i>';

                    $indent = $row->ParentId ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '';

                    // ✅ PERBAIKAN: Tambahkan tanda titik dua (:) sebelum string kosong
                    $badge = $row->children->count() > 0
                        ? '<span class="badge badge-info badge-sm ml-2">Parent (' . $row->children->count() . ' Sub)</span>'
                        : '';

                    return $indent . $icon . '<strong>' . $namaId . '</strong>' .
                        ($namaEn ? '<br><small class="text-muted">' . $namaEn . '</small>' : '') .
                        $badge;
                })
                ->addColumn('LinkInfo', function ($row) {
                    if ($row->JenisLink === 'route') {
                        return '<span class="badge badge-info">Route</span><br><small class="text-muted">' . $row->RouteName . '</small>';
                    } elseif ($row->JenisLink === 'page') {
                        return '<span class="badge badge-success">Page</span><br><small class="text-muted">' . $row->Url . '</small>';
                    }
                    return '<span class="badge badge-secondary">URL</span><br><small class="text-muted">' . substr($row->Url, 0, 30) . '...</small>';
                })
                ->addColumn('PosisiInfo', function ($row) {
                    $badges = [];
                    if ($row->TampilkanDiHeader) {
                        $badges[] = '<span class="badge badge-primary badge-sm">Header</span>';
                    }
                    if ($row->TampilkanDiFooter) {
                        $badges[] = '<span class="badge badge-warning badge-sm">Footer</span>';
                    }
                    if (!$row->TampilkanDiHeader && !$row->TampilkanDiFooter) {
                        return '<span class="text-muted text-small">-</span>';
                    }
                    return implode(' ', $badges);
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm">';
                    $btn .= '<button type="button" class="btn btn-info btn-edit" data-id="' . $row->id . '" title="Edit">';
                    $btn .= '<i class="fa fa-edit"></i></button>';
                    $btn .= '<button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '" data-nama="' . $row->NamaMenu . '" title="Hapus">';
                    $btn .= '<i class="fa fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['MenuNameDisplay', 'LinkInfo', 'PosisiInfo', 'action'])
                ->make(true);
        }

        $allMenus = Menu::with('translations')->orderBy('Urutan')->get();
        $parentMenus = Menu::whereNull('ParentId')->orderBy('Urutan')->get();

        return view('pages.admin.menu.index', compact('allMenus', 'parentMenus'));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('ParentId')->orderBy('Urutan')->get();
        $availableRoutes = $this->getAvailableRoutes();
        return view('pages.admin.menu.create', compact('parentMenus', 'availableRoutes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'translations.id.NamaMenu' => 'required|string|max:255',
            'translations.en.NamaMenu' => 'nullable|string|max:255',
            'JenisLink' => 'required|in:custom,route,page',
            'Url' => 'nullable|string|max:255',
            'RouteName' => 'nullable|string|max:255',
            'ParentId' => 'nullable|exists:Menu,id',
            'Icon' => 'nullable|string|max:100',
            'Urutan' => 'nullable|integer',
            'Target' => 'required|in:_self,_blank',
        ], [
            'translations.id.NamaMenu.required' => 'Nama Menu (Indonesia) wajib diisi.',
        ]);

        $translationsData = $request->input('translations', []);
        $namaMenuId = $translationsData['id']['NamaMenu'] ?? '';

        $data = $request->only([
            'ParentId',
            'JenisLink',
            'Url',
            'RouteName',
            'Icon',
            'Urutan',
            'Target'
        ]);

        // Simpan NamaMenu default (fallback) di tabel utama
        $data['NamaMenu'] = $namaMenuId;
        $data['SlugMenu'] = Str::slug($namaMenuId) . '-' . time();
        $data['StatusAktif'] = $request->has('StatusAktif');
        $data['TampilkanDiHeader'] = $request->has('TampilkanDiHeader');
        $data['TampilkanDiFooter'] = $request->has('TampilkanDiFooter');
        $data['UserCreate'] = auth()->user()->id;

        // Auto urutan jika kosong
        if (empty($data['Urutan'])) {
            $maxUrutan = Menu::where('ParentId', $request->ParentId)->max('Urutan') ?? 0;
            $data['Urutan'] = $maxUrutan + 1;
        }

        $menu = Menu::create($data);

        // Simpan terjemahan
        foreach ($translationsData as $locale => $trans) {
            if (!empty($trans['NamaMenu'])) {
                $menu->translations()->create([
                    'Locale' => $locale,
                    'NamaMenu' => $trans['NamaMenu'],
                ]);
            }
        }

        activity()
            ->performedOn($menu)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $menu->toArray(), 'translations' => $translationsData])
            ->log('Membuat menu: ' . $namaMenuId);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // dd($id);
        // Hapus dd($id) ini sebelum production
        $menu = Menu::with('translations')->findOrFail($id);

        $parentMenus = Menu::whereNull('ParentId')
            ->where('id', '!=', $id) // Mencegah menu menjadi parent dari dirinya sendiri
            ->orderBy('Urutan')
            ->get();

        // Ambil list route Laravel
        $availableRoutes = collect(\Illuminate\Support\Facades\Route::getRoutes()->getRoutes())
            ->filter(fn($r) => $r->getName() && !str_starts_with($r->getName(), 'master.'))
            ->map(fn($r) => ['name' => $r->getName(), 'uri' => $r->uri()])
            ->values();

        return view('pages.admin.menu.edit', compact('menu', 'parentMenus', 'availableRoutes'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'translations.id.NamaMenu' => 'required|string|max:255',
            'translations.en.NamaMenu' => 'nullable|string|max:255',
            'JenisLink' => 'required|in:custom,route,page',
            'Url' => 'nullable|string|max:255',
            'RouteName' => 'nullable|string|max:255',
            'ParentId' => 'nullable|exists:Menu,id',
            'Icon' => 'nullable|string|max:100',
            'Urutan' => 'nullable|integer',
            'Target' => 'required|in:_self,_blank',
            // Tambahkan validasi SlugMenu jika ada di form
            'SlugMenu' => 'nullable|string|max:255|unique:Menu,SlugMenu,' . $menu->id,
        ]);

        $translationsData = $request->input('translations', []);
        $namaMenuId = $translationsData['id']['NamaMenu'] ?? $menu->NamaMenu;

        $data = $request->only([
            'ParentId',
            'JenisLink',
            'Url',
            'RouteName',
            'Icon',
            'Urutan',
            'Target',
            'SlugMenu' // Pastikan ini ada di form jika ingin bisa diedit manual
        ]);

        $data['NamaMenu'] = $namaMenuId;

        // Auto-generate SlugMenu jika kosong, berdasarkan NamaMenu baru
        if (empty($data['SlugMenu'])) {
            $data['SlugMenu'] = \Illuminate\Support\Str::slug($namaMenuId);
        }

        $data['StatusAktif'] = $request->has('StatusAktif');
        $data['TampilkanDiHeader'] = $request->has('TampilkanDiHeader');
        $data['TampilkanDiFooter'] = $request->has('TampilkanDiFooter');

        // PERBAIKAN: Gunakan ->name karena kolom UserUpdate bertipe string
        $data['UserUpdate'] = auth()->user()->name;

        $menu->update($data);

        // Update/Create translations
        foreach ($translationsData as $locale => $trans) {
            $menu->translations()->updateOrCreate(
                ['Locale' => $locale],
                ['NamaMenu' => $trans['NamaMenu'] ?? '']
            );
        }

        activity()
            ->performedOn($menu)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $menu->getOriginal(), // Opsional: untuk log perubahan
                'attributes' => $menu->toArray(),
                'translations' => $translationsData
            ])
            ->log('Update menu: ' . $namaMenuId);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Menu berhasil dihapus!'
        ]);
    }

    // Method untuk ubah urutan
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array'
        ]);

        $orderData = $request->input('order');

        DB::beginTransaction();
        try {
            $orderIndex = 0;
            $this->processOrder($orderData, null, $orderIndex);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    private function processOrder($items, $parentId, &$orderIndex)
    {
        foreach ($items as $item) {
            $menu = Menu::find($item['id']);

            if ($menu) {
                $menu->ParentId = $parentId;
                $menu->Urutan = $orderIndex++;
                $menu->save();

                if (!empty($item['children']) && is_array($item['children'])) {
                    $this->processOrder($item['children'], $menu->id, $orderIndex);
                }
            }
        }
    }

    // Get all available routes
    private function getAvailableRoutes()
    {
        $routes = collect(app('router')->getRoutes()->getRoutes())
            ->filter(function ($route) {
                return !str_contains($route->getName() ?? '', 'debugbar')
                    && !str_contains($route->getName() ?? '', 'ignition')
                    && !str_contains($route->getName() ?? '', 'telescope')
                    && $route->getName() !== null;
            })
            ->map(function ($route) {
                return [
                    'name' => $route->getName(),
                    'uri' => $route->uri(),
                ];
            })
            ->sortBy('name')
            ->values()
            ->toArray();

        return $routes;
    }
}
