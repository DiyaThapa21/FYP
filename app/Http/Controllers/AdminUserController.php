<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Roles;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $admins = User::where('role', 'admin')->get();
        return view('backend.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Roles::all();
        return view('backend.admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $admin = new User;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->role_id = $request->role_id;
        $admin->role = 'admin';
        $admin->save();

        $admin->roles()->sync([$request->role_id]);

        return redirect()->route('admins.index')->with('success', 'Admin added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function show(User $adimn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function edit(User $admin)
    {

        $roles = Roles::all();
        return view('backend.admin.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $admin)

    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id'
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;


        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        $admin->role = 'admin';
        $admin->save();


        $admin->roles()->sync([$request->role_id]);

        return redirect()->route('admins.index')->with('success', 'Admin updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $admin)
    {

        if ($admin->delete()) {
            return redirect()->route('admins.index')->with('success', 'Admin deleted.');
        } else {
            return redirect()->route('admins.index')->with('error', 'Error while deleting admin.');
        }
    }
}
