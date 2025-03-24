<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:access management']);
    }
    /**
     * Display a listing of the resource.
     */

    public function index(): View
    {
        $query = Role::query();
        $this->search($query, ['name']);
        $roles = $query->paginate(20);
        return view('admin.access-management.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissions = Permission::all()->groupBy('group');
        // dd($permissions);
        return view('admin.access-management.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'max:50', 'unique:roles,name']
        ]);
        //Create Role
        $role = Role::create(['guard_name' => 'admin', 'name' => $request->name]);
        //Give permission
        $role->syncPermissions($request->permissions);
        Notify::createdNotification();
        return to_route('admin.role.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // dd($r);
        $role = Role::findOrFail($id);
        // if ($role->name === 'Super Admin') {
        //     return to_route('admin.role.index');
        // }
        $permissions = Permission::all()->groupBy('group');
        $rolePermissions = $role->permissions;
        $rolePermission =  $rolePermissions->pluck('name')->toArray();
        return view('admin.access-management.role.create', compact('permissions', 'role', 'rolePermission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'max:50']
        ]);
        //Create Role
        $role = Role::findOrFail($id);
        $role->update(['guard_name' => 'admin', 'name' => $request->name]);
        //Give permission
        $role->syncPermissions($request->permissions);
        Notify::updatedNotification();
        return to_route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $r = Role::findOrFail($id);
        // dd($r);
        if ($r->name === 'Super Admin') {
            return to_route('admin.role-user.index');
        }
        try {
            Role::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
