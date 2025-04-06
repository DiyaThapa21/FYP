<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {

        $roles = Roles::all();
        return view('backend.role.index', compact('roles'));
    }

    public function create()
    {

        return view('backend.role.create');
    }



    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'nullable'
        ]);

        Roles::create([
            'name' => $request->name,
            'description' => $request->description ?? ''
        ]);

        return redirect()->route('roles.index')->with('success', 'Role added successfully.');
    }

    public function edit($id)
    {
        $role = Roles::findOrFail($id);
        return view('backend.role.edit', compact('role'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'description' => 'nullable|string|max:500',
        ]);

        $role = Roles::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }
}
