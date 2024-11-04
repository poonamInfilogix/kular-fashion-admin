<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::latest()->get();

        return view('setting.taxes.index', compact('taxes'));
    }

    public function create()
    {
        return view('setting.taxes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tax' => 'required',
        ]);

        $status = $request->status == '1' ? 1 : 0;
        $isDefault = $request->default == '1' ? 1 : 0;

        
        if ($isDefault == 1) {
            Tax::where('is_default', 1)->update([
                'is_default' => 0,
            ]);
        }

        Tax::create([
            'tax'        => $request->tax,
            'status'     => $status,
            'is_default' => $isDefault
        ]);

        return redirect()->route('taxes.index')->with('success', 'Tax created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Tax $tax)
    {
        return view('setting.taxes.edit', compact('tax'));
    }

    public function update(Request $request, Tax $tax)
    {
        $request->validate([
            'tax' => 'required',
        ]);

        $status = $request->status == '1' ? 1 : 0; // Convert to integer
        $isDefault = $request->default == '1' ? 1 : 0; // Convert to integer

        if($isDefault == 1) {
            Tax::where('is_default', 1)->update([
                'is_default' => 0
            ]);
        }

        $tax->update([
            'tax'        => $request->tax,
            'status'     => $status,
            'is_default' => $isDefault
        ]);

        return redirect()->route('taxes.index')->with('success', 'Tax updated successfully.');
    }

    public function destroy(Tax $tax)
    {
        $latestTax = Tax::where('id', '!=', $tax->id)
                     ->orderBy('created_at', 'desc')
                     ->first();

        if ($latestTax) {
            $latestTax->update(['is_default' => 1]);
        }

        $tax->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tax deleted successfully.'
        ]);
    }

    public function taxStatus(Request $request)
    {
        $tax = tax::find($request->id);
        if ($tax) {
            $tax->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Tax not found.'], 404);
    }

}
