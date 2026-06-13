<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Menu::with('parent', 'children')->orderBy('Urutan', 'asc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('NamaMenuDisplay', function ($row) {
                    $icon = $row->Icon ? '<i class="' . $row->Icon . ' mr-2"></i>' : '';
                    $indent = $row->ParentId ? '&nbsp;&nbsp;&nbsp;&nbsp;└─ ' : '';
                    return $indent . $icon . '<strong>' . $row->NamaMenu . '</strong>';
                })
                ->addColumn('LinkDisplay', function ($row) {
                    if ($row->JenisLink === 'route') {
                        return '<span class="badge badge-info">Route</span> <code>' . $row->RouteName . '</code>';
                    } elseif ($row->JenisLink === 'page') {
                        return '<span class="badge badge-success">Page</span> <code>' . $row->Url . '</code>';
                    }
                    return '<span class="badge badge-secondary">Custom</span> <code>' . $row->Url . '</code>';
                })
                ->addColumn('StatusBadge', function ($row) {
                    if ($row->StatusAktif) {
                        return '<span class="badge badge-success">Aktif</span>';
                    }
                    return '<span class="badge badge-danger">Nonaktif</span>';
                })
                ->addColumn('PosisiBadge', function ($row) {
                    $badges = [];
                    if ($row->TampilkanDiHeader)
                        $badges[] = '<span class="badge badge-primary">Header</span>';
                    if ($row->TampilkanDiFooter)
                        $badges[] = '<span class="badge badge-warning">Footer</span>';
                    return implode(' ', $badges);
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-sm btn-info btn-up" data-id="' . $row->id . '" title="Naik">
                                <i class="fa fa-arrow-up"></i>
                            </button>
                            <button class="btn btn-sm btn-info btn-down" data-id="' . $row->id . '" title="Turun">
                                <i class="fa fa-arrow-down"></i>
                            </button>
                            <a href="' . route('menu.edit', $row->id) . '" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['NamaMenuDisplay', 'LinkDisplay', 'StatusBadge', 'PosisiBadge', 'action'])
                ->make(true);
        }

        return view('pages.admin.menu.index');
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
            'NamaMenu' => 'required|string|max:255',
            'JenisLink' => 'required|in:custom,route,page',
            'Url' => 'nullable|string|max:255',
            'RouteName' => 'nullable|string|max:255',
            'ParentId' => 'nullable|exists:Menu,id',
            'Icon' => 'nullable|string|max:100',
            'Urutan' => 'nullable|integer',
            'Target' => 'required|in:_self,_blank',
        ]);

        $data = $request->only([
            'ParentId',
            'NamaMenu',
            'JenisLink',
            'Url',
            'RouteName',
            'Icon',
            'Urutan',
            'Target'
        ]);

        $data['SlugMenu'] = Str::slug($request->NamaMenu);
        $data['StatusAktif'] = $request->has('StatusAktif');
        $data['TampilkanDiHeader'] = $request->has('TampilkanDiHeader');
        $data['TampilkanDiFooter'] = $request->has('TampilkanDiFooter');

        // Auto urutan jika kosong
        if (empty($data['Urutan'])) {
            $maxUrutan = Menu::where('ParentId', $request->ParentId)->max('Urutan') ?? 0;
            $data['Urutan'] = $maxUrutan + 1;
        }

        $menu = Menu::create($data);

        // Activity log untuk aksi simpan
        activity()
            ->performedOn($menu)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $menu->toArray()])
            ->log('Membuat menu: ' . $menu->NamaMenu);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $parentMenus = Menu::whereNull('ParentId')
            ->where('id', '!=', $id)
            ->orderBy('Urutan')
            ->get();
        $availableRoutes = $this->getAvailableRoutes();

        return view('pages.admin.menu.edit', compact('menu', 'parentMenus', 'availableRoutes'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'NamaMenu' => 'required|string|max:255',
            'JenisLink' => 'required|in:custom,route,page',
            'Url' => 'nullable|string|max:255',
            'RouteName' => 'nullable|string|max:255',
            'ParentId' => 'nullable|exists:Menu,id',
            'Icon' => 'nullable|string|max:100',
            'Urutan' => 'nullable|integer',
            'Target' => 'required|in:_self,_blank',
        ]);

        $data = $request->only([
            'ParentId',
            'NamaMenu',
            'JenisLink',
            'Url',
            'RouteName',
            'Icon',
            'Urutan',
            'Target'
        ]);

        $data['SlugMenu'] = Str::slug($request->NamaMenu);
        $data['StatusAktif'] = $request->has('StatusAktif');
        $data['TampilkanDiHeader'] = $request->has('TampilkanDiHeader');
        $data['TampilkanDiFooter'] = $request->has('TampilkanDiFooter');

        $old = $menu->getOriginal();

        $menu->update($data);

        // Activity log untuk aksi update
        activity()
            ->performedOn($menu)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $old,
                'attributes' => $menu->toArray()
            ])
            ->log('Mengubah menu: ' . $menu->NamaMenu);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diperbarui!');
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
        $menu = Menu::findOrFail($request->id);

        if ($request->direction === 'up') {
            $prevMenu = Menu::where('ParentId', $menu->ParentId)
                ->where('Urutan', '<', $menu->Urutan)
                ->orderBy('Urutan', 'desc')
                ->first();

            if ($prevMenu) {
                $tempOrder = $menu->Urutan;
                $menu->Urutan = $prevMenu->Urutan;
                $prevMenu->Urutan = $tempOrder;
                $menu->save();
                $prevMenu->save();
            }
        } else {
            $nextMenu = Menu::where('ParentId', $menu->ParentId)
                ->where('Urutan', '>', $menu->Urutan)
                ->orderBy('Urutan', 'asc')
                ->first();

            if ($nextMenu) {
                $tempOrder = $menu->Urutan;
                $menu->Urutan = $nextMenu->Urutan;
                $nextMenu->Urutan = $tempOrder;
                $menu->save();
                $nextMenu->save();
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Urutan berhasil diubah!'
        ]);
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
