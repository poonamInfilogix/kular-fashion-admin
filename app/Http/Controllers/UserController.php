<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Branch;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('branch')->get();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $branches = Branch::where('status','Active')->get();
        return view('users.create',compact('roles','branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email', 
            'name' => 'required', 
            'password' => 'required', 
            'role' => 'required|exists:roles,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "branch_id" => $request->branch_id,
        ]);
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with("success","User created successfully");

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
        $roles = Role::all();
        $user = User::find($id);
        $branches = Branch::where('status','Active')->get();
        return view('users.edit',compact('roles','user','branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email', 
            'name' => 'required', 
            'role' => 'nullable|exists:roles,name'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->branch_id = $request->branch_id;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->assignRole($request->role);
        $user->save();

        return redirect()->back()->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = User::where('id',$id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.'
        ]);
    }
}
