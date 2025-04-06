<?php

namespace App\Http\Controllers;

use App\Models\Permission;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {

        $permissions = Permission::all()->groupBy('module');

        return view('backend.permissions.index', compact('permissions'));
    }

    public function create()
    {

        $modules = Permission::select('module')->distinct()->pluck('module')->toArray();
        return view('backend.permissions.create', compact('modules'));
    }




    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:permissions,name',
            'module' => 'required',
            'custom_module' => 'nullable|string',
        ]);


        $module = ($request->module == 'custom') ? $request->custom_module : $request->module;


        if (!$module) {
            return redirect()->back()->with('error', 'Please provide a valid module name.');
        }

        Permission::create([
            'name' => $request->name,
            'module' => $module,
        ]);

        return redirect()->back()->with('success', 'Permission added successfully.');
    }
}
