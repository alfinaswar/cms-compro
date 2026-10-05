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
    public function __construct()
    {
        $this->middleware('permission:permissions.view')->only(['index']);
        $this->middleware('permission:permissions.create')->only(['create', 'store']);
        $this->middleware('permission:permissions.edit')->only(['edit', 'update']);
        $this->middleware('permission:permissions.delete')->only(['destroy']);
    }

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
                    $btn = '';
                    if (auth()->user()->can('permissions.edit')) {
                        $btn .= '<a href="' . route('permissions.edit', $permission->id) . '" class="btn btn-primary btn-sm me-1">';
                        $btn .= '<i class="fa fa-edit"></i></a> ';
                    }
                    if (auth()->user()->can('permissions.delete')) {
                        $btn .= '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $permission->id . '" data-name="' . $permission->name . '">';
                        $btn .= '<i class="fa fa-trash"></i></button>';
                    }
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
        // ✅ Validasi kondisional: module & action required HANYA jika custom_name kosong
        $request->validate([
            'module' => 'required_without:custom_name|nullable|string|max:100',
            'action' => 'required_without:custom_name|nullable|string|max:100',
            'custom_name' => 'nullable|string|max:255|regex:/^[a-z0-9\-_]+(\.[a-z0-9\-_]+)*$/',
        ], [
            'custom_name.regex' => 'Format permission harus: modul.aksi (huruf kecil, angka, dash, underscore)',
        ]);

        // ✅ Tentukan nama permission berdasarkan input user
        if ($request->filled('custom_name')) {
            $permissionName = strtolower(trim($request->custom_name));
        } else {
            $permissionName = $request->module . '.' . $request->action;
        }

        // Cek duplikat
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

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $parts = explode('.', $permission->name);
        $modules = $this->getModules();
        $actions = $this->getActions();

        // Cek apakah formatnya modul.aksi standar
        $isStandardFormat = count($parts) === 2
            && array_key_exists($parts[0], $modules)
            && array_key_exists($parts[1], $actions);
        // dd($isStandardFormat);
        if ($isStandardFormat) {
            $module = $parts[0];
            $action = $parts[1];
            $customName = $permission->name;
            ;
        } else {
            // Format custom, tampilkan di field custom_name
            $module = '';
            $action = '';
            $customName = $permission->name;
        }

        return view('permissions.edit', compact(
            'permission',
            'modules',
            'actions',
            'module',
            'action',
            'customName'
        ));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // ✅ Validasi kondisional
        $request->validate([
            'module' => 'required_without:custom_name|nullable|string|max:100',
            'action' => 'required_without:custom_name|nullable|string|max:100',
            'custom_name' => 'nullable|string|max:255|regex:/^[a-z0-9\-_]+(\.[a-z0-9\-_]+)*$/',
        ], [
            'custom_name.regex' => 'Format permission harus: modul.aksi (huruf kecil, angka, dash, underscore)',
        ]);

        // Tentukan nama permission baru
        $permissionName = $request->filled('custom_name')
            ? strtolower(trim($request->custom_name))
            : $request->module . '.' . $request->action;

        $permission = Permission::findOrFail($id);
        $oldName = $permission->name;

        // Cek duplikat (kecuali dirinya sendiri)
        if (
            Permission::where('name', $permissionName)
                ->where('id', '!=', $id)
                ->exists()
        ) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['permission' => 'Permission "' . $permissionName . '" sudah ada.']);
        }

        // ✅ Jangan izinkan ubah nama permission (karena bisa merusak relasi role/user)
        if ($oldName !== $permissionName) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['permission' => 'Nama permission tidak boleh diubah karena sudah terikat dengan role. Buat permission baru jika diperlukan.']);
        }

        activity()
            ->performedOn($permission)
            ->causedBy(auth()->user())
            ->withProperties(['attributes' => $permission->toArray()])
            ->log('Mengupdate Permission: ' . $permission->name);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission "' . $permission->name . '" berhasil diperbarui.');
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
