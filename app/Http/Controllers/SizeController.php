<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\SizeScale;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    public function index(SizeScale $sizeScaleId)
    {
        $sizes = $sizeScaleId->sizes()->with('sizeScale')->get();

        return view('size-scales.sizes.index', [
            'sizes' => $sizes,
            'sizeScale' => $sizeScaleId // Pass the SizeScale model to the view
        ]);
    }

    public function create($sizeScaleId)
    {
        $latestSize = Size::orderBy('new_code', 'desc')->first();

        $latestNewCode = $latestSize ? (int)$latestSize->new_code : 0;
        return view('size-scales.sizes.create', compact('sizeScaleId', 'latestNewCode'));
    }

    public function store(Request $request, $sizeScaleId)
    {
        $request->validate([
            'size' => [
                'required',
                Rule::unique('sizes')->where(function ($query) use ($sizeScaleId) {
                    return $query->where('size_scale_id', $sizeScaleId); // Remove the space after 'size_scale_id'
                }),
            ],
            'new_code'      => 'required',
            'old_code'      => 'nullable|min:1|max:5',
        ]);

        Size::create([
            'size_scale_id' => $sizeScaleId,
            'size'          => $request->size,
            'new_code'      => $request->new_code,
            'old_code'      => $request->old_code,
            'status'        => $request->status
        ]);

        return redirect()->route('sizes.index', $sizeScaleId)->with('success', 'Size created successfully.');
    }

    public function edit($sizeScaleId, Size $size)
    {
        return view('size-scales.sizes.edit', compact('size', 'sizeScaleId'));
    }

    public function update(Request $request, $sizeScaleId, Size $size)
    {
        $request->validate([
            'size'          => [
                'required',
                Rule::unique('sizes')->ignore($size->id)->where(function ($query) use ($sizeScaleId) {
                    return $query->where('size_scale_id', $sizeScaleId);
                })
            ],
            'new_code'      => 'required',
            'old_code'      => 'nullable|min:1|max:5',
        ]);

        $size->update([
            'size'          => $request->size,
            'old_code'      => $request->old_code,
            'status'        => $request->status
        ]);

        return redirect()->route('sizes.index', $sizeScaleId)->with('success', 'Size updated successfully.');
    }

    public function destroy($sizeScaleId, Size $size)
    {
        $size->delete();

        return response()->json([
            'success' => true,
            'message' => 'Size deleted successfully.'
        ]);
    }

    public function sizeStatus(Request $request)
    {
        $size = Size::find($request->id);
        if ($size) {
            $size->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Size not found.'], 404);
    }
}
