<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.default-images.index');
    }

    public function store(Request $request)
    {
        $skippedArray = array_slice($request->all(), 1, null, true);

        $settings = [
            'default_department_image'  => 'default_department_image',
            'default_product_type_image' => 'default_product_type_image',
            'default_brand_image'       => 'default_brand_image',
            'default_product_image'     => 'default_product_image'
        ];

        foreach ($settings as $settingKey => $imageKey) {
            $setting = Setting::where('key', $settingKey)->first();
            $oldImagePath = $setting ? $setting->value : null;

            if ($request->hasFile($imageKey)) {
                $newImageName = uploadFile($request->file($imageKey), 'uploads/default-images/');
                $fullOldImagePath = public_path($oldImagePath);

                if ($oldImagePath && File::exists($fullOldImagePath)) {
                    File::delete($fullOldImagePath);
                }
                $skippedArray[$settingKey] = $newImageName;
            } else {
                $skippedArray[$settingKey] = $oldImagePath;
            }
        }

        foreach ($skippedArray as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('settings.index')->with('success', 'Default Images updated successfully');
    }

    public function generalSetting()
    {
        return view('settings.general-settings.index');
    }

    public function generalSettingStore(Request $request)
    {
        $datas = $request->all();
        $skippedArray = array_slice($datas, 1, null, true);

        $request->validate([
            'euro_to_pound' => ['required'],
        ]);

        foreach ($skippedArray as $key => $value)
        {
            Setting::updateOrCreate([
                'key' => $key,
            ],[
                'value' => $value
            ]);
        }

        return redirect()->route('general-settings.index')->with('success', 'General Setting updated successfully');
    }
}
