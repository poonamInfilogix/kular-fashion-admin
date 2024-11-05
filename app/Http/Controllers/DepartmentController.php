<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->get();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('departments')->whereNull('deleted_at'),
            ],
        ]);

        $imageName = uploadFile($request->file('image'), 'uploads/departments/');

        Department::create([
            'name'          => $request->name,
            'status'        => $request->status,
            'description'   => $request->description,
            'image'         => $imageName
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $department = Department::where('id', $id)->first();

        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('departments')->ignore($id)->whereNull('deleted_at'),
            ],
        ]);

        $department = Department::where('id', $id)->first();
        $oldDepartmentImage = $department ? $department->image : NULL;

        if($request->image) {
            $imageName = uploadFile($request->file('image'), 'uploads/departments/');
            $image_path = public_path($oldDepartmentImage);

            if ($oldDepartmentImage && File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $department->update([
            'name'          => $request->name,
            'status'        => $request->status,
            'description'   => $request->description,
            'image'         => $imageName ?? $oldDepartmentImage
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(string $id)
    {
        Department::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully.'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $department = Department::find($request->id);
        if ($department) {
            $department->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.'
            ]);
        }
        return response()->json(['error' => 'Department not found.'], 404);
    }
}
