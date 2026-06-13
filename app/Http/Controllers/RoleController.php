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
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // RoleController.php
    // RoleController.php
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::select('id', 'name');

            return Datatables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($role) {
                    $btn = '';

                    // Show button
                    $btn .= '<a href="' . route('roles.show', $role->id) . '" class="btn btn-info btn-sm me-1">';
                    $btn .= '<i class="fa fa-eye"></i> Show</a> ';

                    // Edit button - tanpa cek permission
                    $btn .= '<a href="' . route('roles.edit', $role->id) . '" class="btn btn-primary btn-sm me-1">';
                    $btn .= '<i class="fa fa-edit"></i> Edit</a> ';

                    // Delete button - tanpa cek permission
                    $btn .= '<button class="btn btn-danger btn-sm btn-delete" data-id="' . $role->id . '" data-name="' . $role->name . '">';
                    $btn .= '<i class="fa fa-trash"></i> Hapus</button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        // Activity Log for Create
        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties([
                'attributes' => $role->toArray(),
                'permissions' => $role->permissions->pluck('name'),
            ])
            ->log('Membuat Role baru: ' . $role->name);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $oldData = $role->toArray();
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        // Activity Log for Update
        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties([
                'old' => $oldData,
                'attributes' => $role->toArray(),
                'permissions' => $role->permissions->pluck('name'),
            ])
            ->log('Mengupdate Role: ' . $role->name);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        DB::table('roles')->where('id', $id)->delete();
        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
