<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();
        return view('branches.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email', 
            'name' => 'required', 
            'short_name' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $branches = Branch::create([
            "name" => $request->name,
            "short_name" => $request->short_name,
            "email" => $request->email,
            "contact" => $request->contact,
            "location" => $request->location,
        ]);

        return redirect()->route('branches.index')->with("success","Branch created successfully");
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
        $branch = Branch::find($id);
        return view('branches.edit',compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email', 
            'name' => 'required', 
            'short_name' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $branches = Branch::create([
            "name" => $request->name,
            "short_name" => $request->short_name,
            "email" => $request->email,
            "contact" => $request->contact,
            "location" => $request->location,
        ]);

        return redirect()->route('branches.edit',$id)->with("success","Branch Updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Branch::where('id', $id)->delete();
        User::where('branch_id', $id)->update([
            "branch_id" => NULL
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.'
        ]);
    }
    public function updateStatus(Request $request)
    {
        $brand = Branch::find($request->id);
        if ($brand) {
            $brand->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Branch not found.'], 404);
    }
}
