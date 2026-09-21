<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::select('id', 'name', 'created_at');

            return Datatables::of($permissions)
                ->addIndexColumn()
                ->addColumn('module', function ($permission) {
                    $parts = explode('.', $permission->name);
                    return count($parts) > 1
                        ? '<span class="badge badge-info">' . ucfirst($parts[0]) . '</span>'
                        : '<span class="badge badge-secondary">General</span>';
                })
                ->addColumn('action_name', function ($permission) {
                    $parts = explode('.', $permission->name);
                    return count($parts) > 1 ? $this->getActionLabel($parts[1]) : '-';
                })
                ->addColumn('action', function ($permission) {
                    $btn = '<a href="' . route('permissions.edit', $permission->id) . '" class="btn btn-primary btn-sm me-1">';
                    $btn .= '<i class="fa fa-edit"></i></a> ';
                    $btn .= '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $permission->id . '" data-name="' . $permission->name . '">';
                    $btn .= '<i class="fa fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['module', 'action', 'action_name'])
                ->make(true);
        }

        return view('permissions.index');
    }

    public function create(): View
    {
        $modules = $this->getModules();
        $actions = $this->getActions();

        return view('permissions.create', compact('modules', 'actions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'module' => 'required|string|max:100',
            'action' => 'required|string|max:100',
            'custom_name' => 'nullable|string|max:255',
        ]);

        // Format permission name: module.action
        $permissionName = $request->module . '.' . $request->action;

        // Cek apakah permission sudah ada
        if (Permission::where('name', $permissionName)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['permission' => 'Permission "' . $permissionName . '" sudah ada.']);
        }

        $permission = Permission::create(['name' => $permissionName]);

        activity()
            ->performedOn($permission)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $permission->toArray()])
            ->log('Membuat Permission baru: ' . $permission->name);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission "' . $permission->name . '" berhasil ditambahkan.');
    }

    public function edit($id): View
    {
        $permission = Permission::findOrFail($id);
        $modules = $this->getModules();
        $actions = $this->getActions();

        // Parse existing permission name
        $parts = explode('.', $permission->name);
        $module = count($parts) > 1 ? $parts[0] : 'general';
        $action = count($parts) > 1 ? $parts[1] : $permission->name;

        return view('permissions.edit', compact('permission', 'modules', 'actions', 'module', 'action'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $oldName = $permission->name;

        $request->validate([
            'module' => 'required|string|max:100',
            'action' => 'required|string|max:100',
        ]);

        $newPermissionName = $request->module . '.' . $request->action;

        // Cek apakah permission baru sudah ada (kecuali permission yang sedang diedit)
        if (
            Permission::where('name', $newPermissionName)
                ->where('id', '!=', $id)
                ->exists()
        ) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['permission' => 'Permission "' . $newPermissionName . '" sudah ada.']);
        }

        $permission->update(['name' => $newPermissionName]);

        activity()
            ->performedOn($permission)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => ['name' => $oldName],
                'attributes' => $permission->toArray(),
            ])
            ->log('Mengupdate Permission dari "' . $oldName . '" menjadi "' . $newPermissionName . '"');

        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil diperbarui menjadi "' . $newPermissionName . '".');
    }

    public function destroy($id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);
        $name = $permission->name;

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission "' . $name . '" berhasil dihapus.');
    }

    /**
     * Get list of common modules
     */
    private function getModules()
    {
        return [
            'berita' => 'Berita & Artikel',
            'halaman' => 'Halaman',
            'solusi' => 'Solusi',
            'karir' => 'Karir',
            'kontak' => 'Kontak',
            'menu' => 'Menu',
            'user' => 'User',
            'role' => 'Role',
            'permission' => 'Permission',
            'setting' => 'Setting',
            'master' => 'Master Data',
            'laporan' => 'Laporan',
            'custom' => 'Custom (Manual)',
        ];
    }

    /**
     * Get list of common actions
     */
    private function getActions()
    {
        return [
            'view' => 'View (Melihat)',
            'create' => 'Create (Menambah)',
            'edit' => 'Edit (Mengubah)',
            'delete' => 'Delete (Menghapus)',
            'update' => 'Update (Memperbarui)',
            'store' => 'Store (Menyimpan)',
            'destroy' => 'Destroy (Menghapus Permanen)',
            'publish' => 'Publish (Menerbitkan)',
            'manage' => 'Manage (Mengelola)',
            'export' => 'Export (Mengekspor)',
            'import' => 'Import (Mengimpor)',
            'custom' => 'Custom (Manual)',
        ];
    }

    /**
     * Get human-readable action label
     */
    private function getActionLabel($action)
    {
        $labels = [
            'view' => 'Melihat',
            'create' => 'Menambah',
            'edit' => 'Mengubah',
            'update' => 'Memperbarui',
            'delete' => 'Menghapus',
            'destroy' => 'Hapus Permanen',
            'store' => 'Menyimpan',
            'publish' => 'Menerbitkan',
            'manage' => 'Mengelola',
            'export' => 'Mengekspor',
            'import' => 'Mengimpor',
        ];
        return $labels[$action] ?? ucfirst($action);
    }
}
