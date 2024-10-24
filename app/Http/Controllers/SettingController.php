<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    public function store(Request $request)
    {
        $datas = $request->all();
        $skippedArray = array_slice($datas, 1, null, true);

        $categoryImage = Setting::where('key','category_image')->first();
        $oldCategoryImage = $categoryImage ? $categoryImage->value : NULL;
        if($request->category_image) {
            $categoryImageName = uploadFile($request->file('category_image'), 'uploads/default-images/');
            $image_path = public_path($oldCategoryImage);

            if ($oldCategoryImage && File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $subCategoryImage = Setting::where('key','subcategory_image')->first();
        $oldSubCategoryImage = $subCategoryImage ? $subCategoryImage->value : NULL;
        if($request->subcategory_image) {
            $subCategoryImageName = uploadFile($request->file('subcategory_image'), 'uploads/default-images/');
            $image_path = public_path($oldSubCategoryImage);

            if ($oldSubCategoryImage && File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $skippedArray['category_image'] = $categoryImageName ??  $oldCategoryImage;
        $skippedArray['subcategory_image'] = $subCategoryImageName ??  $oldSubCategoryImage;


        foreach ($skippedArray as $key => $value)
        {
            Setting::updateOrCreate([
                'key' => $key,
            ],[
                'value' => $value
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Setting updated successfully');
    }
}
