<?php

namespace App\Http\Controllers;

use App\Models\ChangePriceReason;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChangePriceReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reasons = ChangePriceReason::latest()->get();
        return view('settings.change-price-reasons.index', compact('reasons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.change-price-reasons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|max:100|unique:change_price_reasons,name',
        ]);

        ChangePriceReason::create([
            'name' => $request->reason,
        ]);

        return redirect()->route('change-price-reasons.index')->with('success', 'New reason added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChangePriceReason $changePriceReason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChangePriceReason $changePriceReason)
    {
        return view('settings.change-price-reasons.edit', compact('changePriceReason'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChangePriceReason $changePriceReason)
    {
        $request->validate([
            'reason' => [
                'required',
                'max:100',
                Rule::unique('change_price_reasons', 'name')->ignore($changePriceReason->id)->whereNull('deleted_at'),
            ]
        ]);

        $changePriceReason->name = $request->reason;
        $changePriceReason->save();
        return redirect()->route('change-price-reasons.index')->with('success', 'Reason updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChangePriceReason $changePriceReason)
    {
        $changePriceReason->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reason deleted successfully.'
        ]);
    }
}
