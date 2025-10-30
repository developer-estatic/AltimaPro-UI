<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $roles = Role::orderBy('id', 'asc')->paginate(20);
        return view('role_management.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::all();
        $permission = Permission::get();
        $modules = Module::where('status', 1)->get();
        return view('role_management.create', compact('modules', 'permission', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $request->validated();

        $permissionsID = array_map(
            function ($value) {
                return (int)$value;
            },
            $request->input('permission')
        );

        $role = Role::create(['name' => $request->input('name'), 'parent_id' => $request->input('parent_id')]);
        $role->syncPermissions($permissionsID);

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $roles = Role::all();
        $role = Role::find($id);
        $modules = Module::where('status', 1)->get();
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role_management.edit', compact('role', 'modules', 'permission', 'rolePermissions', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id): RedirectResponse
    {
        $request->validated();

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->parent_id = $request->input('parent_id');
        $role->save();

        $permissionsID = array_map(
            function ($value) {
                return (int)$value;
            },
            $request->input('permission')
        );

        $role->syncPermissions($permissionsID);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        try {
            Role::where('id', $id)->delete();
        } catch (\Exception $e) {
            redirect()->route('roles.index')->with('error', 'Role cannot be deleted. <br> Incident ID: ' . log_incident($e));
        }
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
