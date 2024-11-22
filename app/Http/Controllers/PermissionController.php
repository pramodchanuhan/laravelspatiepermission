<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; 


class PermissionController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
           new Middleware('permission:view permissions',only: ['index']),
           new Middleware('permission:edit permissions',only: ['edit']),
           new Middleware('permission:create permissions',only: ['create']),
           new Middleware('permission:delete permissions',only: ['destroy']),  
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate('10');
        return view('permissions.list',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions|min:3'
        ]);
        Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success','Permissions added sucessfully');

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
        $permission = Permission::findOrFail($id);
        return view('permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findorfail($id);
        $validated = request()->validate([
            'name' => 'required|unique:permissions,name,'.$id.',id|min:3|max:255|',
        ]);
        $permission->update([
            'name' => request('name')
        ]);
        return redirect()->route('permissions.index')->with('success', 'Permission Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,){
        $permission = Permission::findorfail($request->id);
     
        if($permission==null){
            session()->flash('error', 'Permission Not Found');
            return response()->json([
                'status' => false,               
            ]);
        }
        else{
            $permission->delete();
            session()->flash('error', 'Permission Deleted Successfully');
            return response()->json([
                'status' => true,               
            ]);
        }
    }
}
