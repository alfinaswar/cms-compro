<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use DB;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::select('id', 'name');

            return Datatables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($role) {
                    $btn = '<a href="' . route('roles.edit', $role->id) . '" class="btn btn-primary btn-sm me-1">';
                    $btn .= '<i class="fa fa-edit"></i> Ubah</a> ';
                    $btn .= '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $role->id . '" data-name="' . $role->name . '">';
                    $btn .= '<i class="fa fa-trash"></i> Hapus</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('roles.index');
    }

    public function create(): View
    {
        // Ambil permission yang sudah dikelompokkan
        $groupedPermissions = $this->getGroupedPermissions();
        return view('roles.create', compact('groupedPermissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array|min:1',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties([
                'attributes' => $role->toArray(),
                'permissions' => $role->permissions->pluck('name'),
            ])
            ->log('Membuat Role baru: ' . $role->name);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
    }

    public function show($id): View
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id): View
    {
        $role = Role::findOrFail($id);
        $groupedPermissions = $this->getGroupedPermissions();

        // Ambil ID permission yang sudah dimiliki role ini
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'required|array|min:1',
        ]);

        $role = Role::findOrFail($id);
        $oldData = $role->toArray();

        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $oldData,
                'attributes' => $role->toArray(),
                'permissions' => $role->permissions->pluck('name'),
            ])
            ->log('Mengupdate Role: ' . $role->name);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete(); // Lebih aman daripada DB::table()->delete() karena menangani relasi spatie

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }

    /**
     * Helper: Mengelompokkan permission berdasarkan modul (prefix)
     */
    private function getGroupedPermissions()
    {
        $permissions = Permission::orderBy('name')->get();
        $grouped = [];

        // Label human-readable untuk aksi
        $actionLabels = [
            'view' => 'Melihat',
            'create' => 'Menambah',
            'edit' => 'Mengubah',
            'update' => 'Mengubah',
            'delete' => 'Menghapus',
            'manage' => 'Mengelola',
            'publish' => 'Menerbitkan',
            'export' => 'Mengekspor',
        ];

        foreach ($permissions as $permission) {
            // Pisahkan berdasarkan titik (contoh: 'berita.view' -> module: 'berita', action: 'view')
            $parts = explode('.', $permission->name);
            $module = count($parts) > 1 ? ucfirst($parts[0]) : 'General';
            $action = count($parts) > 1 ? $parts[1] : $permission->name;

            $label = $actionLabels[$action] ?? ucfirst($action);

            $grouped[$module][] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'label' => $label
            ];
        }

        return $grouped;
    }
}
