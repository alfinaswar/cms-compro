<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use DB;
use Illuminate\Support\Facades\Route;

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
        $allMenus = Menu::with('translations')->orderBy('Urutan')->get();
        $parentMenus = Menu::whereNull('ParentId')->orderBy('Urutan')->get();

        // ✅ AMBIL SEMUA ROUTE LARAVEL YANG PUNYA NAMA
        $availableRoutes = collect(Route::getRoutes()->getRoutes())
            ->filter(function ($route) {
                return $route->getName() &&
                    !str_starts_with($route->getName(), 'debugbar') &&
                    !str_starts_with($route->getName(), 'ignition') &&
                    !str_starts_with($route->getName(), 'livewire') &&
                    !str_starts_with($route->getName(), 'admin');
            })

            ->map(function ($route) {
                return [
                    'name' => $route->getName(),
                    'uri' => $route->uri(),
                    'method' => implode(',', $route->methods())
                ];
            })
            ->sortBy('name')
            ->values();
        return view('pages.admin.menu.index', compact('allMenus', 'parentMenus', 'availableRoutes'));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('ParentId')->orderBy('Urutan')->get();
        $availableRoutes = $this->getAvailableRoutes();
        return view('pages.admin.menu.create', compact('parentMenus', 'availableRoutes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'translations.id.NamaMenu' => 'required|string|max:255',
            'translations.en.NamaMenu' => 'nullable|string|max:255',
            'JenisLink' => 'required|in:page,custom,route',
            'Url' => 'nullable|string',
            'RouteName' => 'nullable|string',
            'ParentId' => 'nullable|exists:menu,id',
            'Icon' => 'nullable|string',
            'Urutan' => 'nullable|integer',
            'StatusAktif' => 'nullable|boolean',
            'TampilkanDiHeader' => 'nullable|boolean',
            'TampilkanDiFooter' => 'nullable|boolean',
            'Target' => 'nullable|string|in:_self,_blank',
        ]);

        // Generate SlugMenu unik
        $slug = Str::slug($validated['translations']['id']['NamaMenu']);
        $originalSlug = $slug;
        $count = 1;
        while (Menu::where('SlugMenu', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $menu = Menu::create([
            'ParentId' => $validated['ParentId'] ?? null,
            'SlugMenu' => $slug,
            'JenisLink' => $validated['JenisLink'],
            'Url' => $validated['Url'] ?? null,
            'RouteName' => $validated['RouteName'] ?? null,
            'Icon' => $validated['Icon'] ?? null,
            'Urutan' => $validated['Urutan'] ?? 0,
            'StatusAktif' => $request->has('StatusAktif'),
            'TampilkanDiHeader' => $request->has('TampilkanDiHeader'),
            'TampilkanDiFooter' => $request->has('TampilkanDiFooter'),
            'Target' => $validated['Target'] ?? '_self',
        ]);

        // Simpan Translations
        foreach (['id', 'en'] as $locale) {
            if (!empty($validated['translations'][$locale]['NamaMenu'])) {
                $menu->translations()->create([
                    'Locale' => $locale,
                    'NamaMenu' => $validated['translations'][$locale]['NamaMenu'],
                ]);
            }
        }
        activity()
            ->causedBy(auth()->user())
            ->performedOn($menu)
            ->withProperties([
                'attributes' => $menu->toArray(),
            ])
            ->event('created')
            ->log('Menambahkan menu baru: ' . $menu->NamaMenu);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
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
        // dd($parentMenus);
        // Ambil list route Laravel
        $availableRoutes = collect(\Illuminate\Support\Facades\Route::getRoutes()->getRoutes())
            ->filter(fn($r) => $r->getName() && !str_starts_with($r->getName(), 'master.'))
            ->map(fn($r) => ['name' => $r->getName(), 'uri' => $r->uri()])
            ->values();
        // dd($availableRoutes);
        return view('pages.admin.menu.edit', compact('menu', 'parentMenus', 'availableRoutes'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'translations.id.NamaMenu' => 'required|string|max:255',
            'translations.en.NamaMenu' => 'nullable|string|max:255',
            'JenisLink' => 'required|in:page,custom,route',
            'Url' => 'nullable|string',
            'RouteName' => 'nullable|string',
            'ParentId' => 'nullable|exists:menu,id',
            'Icon' => 'nullable|string',
            'Urutan' => 'nullable|integer',
            'StatusAktif' => 'nullable|boolean',
            'TampilkanDiHeader' => 'nullable|boolean',
            'TampilkanDiFooter' => 'nullable|boolean',
            'Target' => 'nullable|string|in:_self,_blank',
        ]);

        $menu = Menu::findOrFail($id);

        // Cegah circular reference
        if ($validated['ParentId'] == $menu->id) {
            return back()->with('error', 'Menu tidak bisa menjadi parent dari dirinya sendiri.');
        }

        $menu->update([
            'ParentId' => $validated['ParentId'] ?? null,
            'JenisLink' => $validated['JenisLink'],
            'Url' => $validated['Url'] ?? null,
            'RouteName' => $validated['RouteName'] ?? null,
            'Icon' => $validated['Icon'] ?? null,
            'Urutan' => $validated['Urutan'] ?? 0,
            'StatusAktif' => $request->has('StatusAktif'),
            'TampilkanDiHeader' => $request->has('TampilkanDiHeader'),
            'TampilkanDiFooter' => $request->has('TampilkanDiFooter'),
            'Target' => $validated['Target'] ?? '_self',
        ]);

        // Update Translations
        foreach (['id', 'en'] as $locale) {
            $namaMenu = $validated['translations'][$locale]['NamaMenu'] ?? null;
            if ($namaMenu) {
                $menu->translations()->updateOrCreate(
                    ['Locale' => $locale],
                    ['NamaMenu' => $namaMenu]
                );
            }
        }

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $menu->delete(); // Cascade delete akan menangani children & translations

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus menu: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk ubah urutan
    public function updateOrder(Request $request)
    {
        $request->validate(['order' => 'required|array']);
        $orderData = $request->input('order');

        DB::beginTransaction();
        try {
            $orderIndex = 0;
            $this->processOrder($orderData, null, $orderIndex);
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
