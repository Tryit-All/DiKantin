<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleHasPermissions;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use HasRoles;

    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-update', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {
        $roles = Roles::orderBy('id', 'DESC')->paginate(100);
        return view('dashboard.roles.index', compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = Permission::get();
        return view('dashboard.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required'
        ]);

        $role = Roles::create(['name' => $request->input('name'), 'guard_name' => 'web']);
        // dd($role);
        $newRole = Roles::latest()->first();
        // dd($newRole);
        foreach ($request->input('permission') as $key => $value) {
            # code...
            RoleHasPermissions::create([
                'permission_id' => $value,
                "role_id" => $newRole->id
            ]);
        }
        // $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('success', 'Role Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Roles::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")->where("role_has_permissions.role_id", $id)->get();

        return view('dashboard.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Roles::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('dashboard.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        // return $request;
        $role = Roles::with('permissions')->find($id);


        try {
            //code...
            $role->permissions()->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            //code...
            $role->name = $request->input('name');
            $role->save();

            foreach ($request->input('permission') as $key => $value) {
                # code...
                RoleHasPermissions::create([
                    'permission_id' => $value,
                    "role_id" => $role->id
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
        }



        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        Roles::where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
