<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleUserCreateRequest;
use App\Models\Admin;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleUserController extends Controller
{

    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:pagebuilder create|pagebuilder update|pagebuilder delete'])->only(['index']);
        $this->middleware(['permission:pagebuilder create'])->only(['create', 'store']);
        $this->middleware(['permission:pagebuilder update'])->only(['edit', 'update']);
        $this->middleware(['permission:pagebuilder delete'])->only(['destroy']);
    }

    public function index(): View
    {
        $query = Admin::query();
        $this->search($query, ['name']);
        $admins = $query->paginate(20);
        return view('admin.access-management.role-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.access-management.role-user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleUserCreateRequest $request)
    {
        // dd($request->all());
        $user = Admin::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]
        );
        $user->assignRole($request->role);
        Notify::createdNotification();
        return to_route('admin.role-user.index');
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
        $a = Admin::findOrFail($id);
        if ($a->getRoleNames()->first() === 'Super Admin') {
            return to_route('admin.role-user.index');
        }
        $admin = Admin::findOrFail($id);
        $roles = Role::all();
        return view('admin.access-management.role-user.create', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:admins,email,' . $id],
            'password' => ['confirmed'],
            'role' => ['required']
        ]);
        $user = Admin::findOrFail($id);
        $pass = $request->password ? bcrypt($request->password) : $user->password;
        $user->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $pass,
            ]
        );
        $user->syncRoles($request->role);
        Notify::updatedNotification();
        return to_route('admin.role-user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        if ($admin->getRoleNames()->first() === 'Super Admin') {
            return response(['message' => 'You Cant Delete Super Admin'], 500);
        }
        try {
            Admin::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
