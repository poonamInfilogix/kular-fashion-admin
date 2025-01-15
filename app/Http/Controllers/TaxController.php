<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use Illuminate\Support\Facades\Gate;

class TaxController extends Controller
{
    public function index()
    {
        if(!Gate::allows('view tax')) {
            abort(403);
        }
        $taxes = Tax::latest()->get();

        return view('settings.tax-settings.index', compact('taxes'));
    }

    public function create()
    {
        if(!Gate::allows('create tax')) {
            abort(403);
        }
        return view('settings.tax-settings.create');
    }

    public function store(Request $request)
    {
        if(!Gate::allows('create tax')) {
            abort(403);
        }
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

        return redirect()->route('tax-settings.index')->with('success', 'Tax setting created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        if(!Gate::allows('edit tax')) {
            abort(403);
        }
        $tax = Tax::where('id', $id)->first();

        return view('settings.tax-settings.edit', compact('tax'));
    }

    public function update(Request $request, $id)
    {
        if(!Gate::allows('edit tax')) {
            abort(403);
        }
        $request->validate([
            'tax' => 'required',
        ]);

        $status = $request->status == '1' ? 1 : 0;
        $isDefault = $request->default == '1' ? 1 : 0;

        if($isDefault == 1) {
            Tax::where('is_default', 1)->update([
                'is_default' => 0
            ]);
        }

        Tax::where('id', $id)->update([
            'tax'        => $request->tax,
            'status'     => $status,
            'is_default' => $isDefault
        ]);

        return redirect()->route('tax-settings.index')->with('success', 'Tax setting updated successfully.');
    }

    public function destroy($id)
    {
        if(!Gate::allows('delete tax')) {
            abort(403);
        }
        $latestTax = Tax::where('id', '!=', $id)
                     ->orderBy('created_at', 'desc')
                     ->first();

        if ($latestTax) {
            $latestTax->update(['is_default' => 1]);
        }

        Tax::where('id', $id)->delete();

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
