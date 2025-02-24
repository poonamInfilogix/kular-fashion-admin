<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view branches')) {
            abort(403);
        }
        $branches = Branch::all();
        $branchesWithTransfers = [];
        foreach ($branches as $branch) {
            $branchesWithTransfers[$branch->id] = $branch->sentTransfers()->exists() || $branch->receivedTransfers()->exists();
        }

        return view('branches.index',compact('branches', 'branchesWithTransfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create branches')) {
            abort(403);
        }
        $defaultFooter = setting('order_receipt_footer');
        $defaultHeader = setting('order_receipt_header');

        return view('branches.create', compact('defaultFooter', 'defaultHeader'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Gate::allows('create branches')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:branches,email', 
            'name' => 'required', 
            'short_name' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Branch::create([
            "name" => $request->name,
            "short_name" => $request->short_name,
            "email" => $request->email,
            "contact" => $request->contact,
            "location" => $request->location,
            "order_receipt_header" => $request->order_receipt_header,
            "order_receipt_footer" => $request->order_receipt_footer,
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
    public function edit(Branch $branch)
    {
        if(!Gate::allows('edit branches')) {
            abort(403);
        }

        $defaultFooter = setting('order_receipt_footer');
        $defaultHeader = setting('order_receipt_header');

        return view('branches.edit',compact('branch', 'defaultHeader', 'defaultFooter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!Gate::allows('edit branches')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:branches,email,' . $id,
            'name' => 'required', 
            'short_name' => 'required', 
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $branch = Branch::findOrFail($id);
        $branch->update([
            "name" => $request->name,
            "short_name" => $request->short_name,
            "email" => $request->email,
            "contact" => $request->contact,
            "location" => $request->location,
            "order_receipt_header" => $request->order_receipt_header,
            "order_receipt_footer" => $request->order_receipt_footer,
        ]);

        return redirect()->route('branches.edit',$id)->with("success","Branch Updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!Gate::allows('delete branches')) {
            abort(403);
        }
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
