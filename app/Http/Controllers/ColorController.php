<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->get();

        return view('colors.index', compact('colors'));
    }

    public function create()
    {
        return view('colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'color_name'       => 'required',
            'color_short_code' => 'required'
        ]);

        Color::create([
            'color_name'       => $request->color_name,
            'color_short_code' => $request->color_short_code,
            'color_picker'     => $request->color_picker,
            'status'           => $request->status,
        ]);

        return redirect()->route('colors.index')->with('success', 'Color created successfully.');
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        $color = Color::where('id', $id)->first();

        return view('colors.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'color_name'       => 'required',
            'color_short_code' => 'required'
        ]);

        $color = Color::where('id', $id)->first();
        $color->update([
            'color_name'        => $request->color_name,
            'color_short_code'  => $request->color_short_code,
            'color_picker'      => $request->color_picker,
            'status'            => $request->status,
        ]);

        return redirect()->route('colors.index')->with('success', 'Color updated successfully.');
    }

    public function destroy(string $id)
    {
        Color::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Color deleted successfully.'
        ]);
    }

    public function colorStatus(Request $request)
    {
        $color = Color::find($request->id);
        if ($color) {
            $color->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Color not found.'], 404);
    }
}
