<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; 

class RoleController extends Controller implements HasMiddleware
{
    
    
    public static function middleware()
    {
        return [
           new Middleware('permission:view roles',only: ['index']),
           new Middleware('permission:edit roles',only: ['edit']),
           new Middleware('permission:create roles',only: ['create']),
           new Middleware('permission:delete roles',only: ['destroy']),  
        ];
    }/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->paginate('10');
        return view('roles.list',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|min:3'
        ]);
        Role::create(['name' => $request->name]);
        if($request->permission){
            $role = Role::where('name', $request->name)->first();
            $role->syncPermissions($request->permission);
        }
        return redirect()->route('roles.index')->with('success','Roles added sucessfully');

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
        $permissions = Permission::get();
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        return view('roles.edit',compact('role','hasPermissions','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $role = Role::findOrfail($id);
        $request->validate([
            'name' => 'required|min:3|unique:roles,name,' . $id
        ]);
        $role->name = $request->name;
        $role->save();
        if($request->permission){
            $role->syncPermissions($request->permission);
        }
        else{
            $role->syncPermissions([]);
        }
        return redirect()->route('roles.index')->with('success','Roles updated sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id  = $request->id;
        $role = Role::find($id);
        if($role){
            $role->delete();
            session()->flash('success','Role deleted sucessfully');
            return response()->json(['status' => true,'message' => 'Role deleted sucessfully'], 200);
        }
        else{

            session()->flash('error','Role not found');
            return response()->json(['status' => false,'message' => 'Role not found'], 404);
        }
    }
}
