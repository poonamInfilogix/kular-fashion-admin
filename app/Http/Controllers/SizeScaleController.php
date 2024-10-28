<?php

namespace App\Http\Controllers;

use App\Models\SizeScale;
use Illuminate\Http\Request;

class SizeScaleController extends Controller
{
    public function index()
    {
        $sizeScales = SizeScale::latest()->get();

        return view('size-scales.index', compact('sizeScales'));
    }

    public function create()
    {
        return view('size-scales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'size_scale' => 'required',
        ]);

        SizeScale::create([
            'size_scale'       => $request->size_scale,
            'status'           => $request->status,
        ]);

        return redirect()->route('size-scales.index')->with('success', 'Size Scale created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $sizeScale = SizeScale::where('id', $id)->first();

        return view('size-scales.edit', compact('sizeScale'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'size_scale' => 'required',
        ]);

        $sizeScale = SizeScale::where('id', $id)->first();

        $sizeScale->update([
            'size_scale' => $request->size_scale,
            'status'     => $request->status
        ]);

        return redirect()->route('size-scales.index')->with('success', 'Size Scale updated successfully.');
    }

    public function destroy(string $id)
    {
        SizeScale::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Size Status deleted successfully.'
        ]);
    }

    public function sizeScaleStatus(Request $request)
    {
        $sizeScale = SizeScale::find($request->id);
        if ($sizeScale) {
            $sizeScale->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Size Scale not found.'], 404);
    }
}
