<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Module;
use Illuminate\Support\Facades\Gate;

class RoleAndPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*if (!Gate::allows('view roles & permissions')) {
            abort(403);
        }*/

        $roles = Role::where('id', '!=', '1')->get();
        $modules = Module::get();
        return view('permissions.index',compact('roles', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::find($request->role_id);
        
        if($request->permissions) {
            foreach($request->permissions as $permission){
                $existingPermission = Permission::where('name', $permission)->first();
                if(!$existingPermission){
                    Permission::create(['name' => $permission]);
                    
                    $super_admin_role = Role::where('name', 'Admin')->first();
                    $super_admin_role->givePermissionTo($permission);
                }
            }
        }
        $role->syncPermissions($request->permissions);

        return redirect()->to(route('roles-and-permissions.index'))->with('success', 'Permissions updated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roles = Role::where('id', '!=', 1)->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::where('id', $id)->first();
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Role::where('id',$id)->update([
            'name' => $request->role
        ]);
        return redirect()->to(route('roles-and-permissions.role-list'))->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::where('id',$id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.'
        ]);
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles,name',  
        ]);
    
        Role::create([
            'name' => $request->input('role'),
        ]);
    
        return redirect()->route('roles-and-permissions.role-list')->with('success', 'Role created successfully.');
    }

}
