<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Gate;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view suppliers')) {
            abort(403);
        }
        $suppliers = Supplier::latest()->get();

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('create suppliers')) {
            abort(403);
        }
        $countries = Country::latest()->get();

        return view('suppliers.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Gate::allows('create suppliers')) {
            abort(403);
        }
        $request->validate([
            'short_code'          => 'required',
            'supplier_name'       => 'required',
            'supplier_ref'        => 'required',
        ]);

        Supplier::create([
            'short_code'    => $request->short_code,
            'supplier_name' => $request->supplier_name,
            'supplier_ref'  => $request->supplier_ref,
            'telephone'     => $request->telephone,
            'email'         => $request->email,
            'address_line_1'=> $request->address_line_1,
            'address_line_2'=> $request->address_line_2,
            'country_id'    => $request->country_id,
            'state_id'      => $request->state_id,
            'city'          => $request->city,
            'postal_code'   => $request->postal_code,
            'status'        => $request->status
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
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
    public function edit(Supplier $supplier)
    {
        if(!Gate::allows('edit suppliers')) {
            abort(403);
        }
        $countries = Country::latest()->get();
        $states = $supplier->country_id ? State::where('country_id', $supplier->country_id)->get() : [];
        return view('suppliers.edit', compact('supplier', 'countries', 'states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        if(!Gate::allows('edit suppliers')) {
            abort(403);
        }
        $request->validate([
            'short_code'          => 'required',
            'supplier_name'       => 'required',
            'supplier_ref'        => 'required',
        ]);

        $supplier->update([
            'short_code'    => $request->short_code,
            'supplier_name' => $request->supplier_name,
            'supplier_ref'  => $request->supplier_ref,
            'telephone'     => $request->telephone,
            'email'         => $request->email,
            'address_line_1'=> $request->address_line_1,
            'address_line_2'=> $request->address_line_2,
            'country_id'    => $request->country_id,
            'state_id'      => $request->state_id,
            'city'          => $request->city,
            'postal_code'   => $request->postal_code,
            'status'        => $request->status
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if(!Gate::allows('delete suppliers')) {
            abort(403);
        }
        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Supplier deleted successfully.'
        ]);
    }

    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get();
        return response()->json(['states' => $states]);
    }

    public function supplierStatus(Request $request)
    {
        $supplier = Supplier::find($request->id);
        if ($supplier) {
            $supplier->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Supplier Scale not found.'], 404);
    }
}
