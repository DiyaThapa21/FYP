<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Permission;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    public function index()
    {

        $roles = Roles::with('permissions')->get();
        $permissions = Permission::all()->groupBy('module');

        return view('backend.assignpermission.index', compact('roles', 'permissions'));
    }


    public function create()
    {

        $roles = Roles::all();
        $permissions = Permission::all()->groupBy('module');

        return view('backend.assignpermission.create', compact('roles', 'permissions'));
    }



    public function store(Request $request)
    {

        $role = Roles::findOrFail($request->role_id);
        $role->permissions()->sync($request->permission_ids);

        return redirect()->back()->with('success', 'Permissions assigned successfully.');
    }


    public function edit($id)
    {

        $role = Roles::findOrFail($id);
        $roles = Roles::all();
        $permissions = Permission::all()->groupBy('module');
        $assignedPermissions = $role->permissions->pluck('id')->toArray();

        return view('backend.assignpermission.edit', compact('role', 'roles', 'permissions', 'assignedPermissions'));
    }



    public function update(Request $request, $id)
    {

        $role = Roles::findOrFail($id);
        $role->permissions()->sync($request->permission_ids ?? []);

        return redirect()->route('assignpermissions.index')->with('success', 'Permissions updated successfully.');
    }
}
