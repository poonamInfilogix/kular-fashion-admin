<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

class SettingController extends Controller
{
    public function index()
    {
        if(!Gate::allows('view settings')) {
            abort(403);
        }
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


    public function webSetting(){
        return view('settings.web-settings.index');
    }

    public function webSettingStore(Request $request){
        $request->validate([
            'website_title' => 'required',
            "web_contact_email" => 'required',
            "web_contact_no" => 'required',
        ]);

        $skippedArray = array_slice($request->all(), 1, null, true);

        $web_settings = [
            'site_logo'  => 'site_logo',
            'web_favicon' => 'web_favicon',
        ];

        foreach ($web_settings as $settingKey) {
            $setting = Setting::where('key', $settingKey)->first();
            $oldImagePath = $setting ? $setting->value : null;
           
            if ($request->hasFile($settingKey)) {
                $newImageName = uploadFile($request->file($settingKey), 'uploads/default-images/');
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

        return redirect()->route('web-settings.index')->with('success', 'Web Setting updated successfully');
    }

    public function paymentMethodSettings(){
        return view('settings.payment-methods.index');
    }

    public function paymentMethodUpdate(Request $request){
        dd($request->all());
    }

    public function shippingMethodSettings(){
        return view('settings.shipping-methods.index');
    }

    public function shippingMethodUpdate(Request $request, $method){
        $rules = [
            $method . '_api_endpoint' => 'required|url', 
            $method . '_status' => 'required|boolean'
        ];

        if ($method === 'royal_mail') {
            $rules[$method . '_api_key'] = 'required|string';
        }

        if ($method === 'dpd') {
            $rules[$method . '_api_token'] = 'required|string';
        }

        $request->validate($rules);

        $skippedArray = array_slice($request->all(), 1, null, true);

        foreach ($skippedArray as $key => $value) {
            if($key === 'royal_mail_api_key' || $key === 'dpd_api_token'){
                $value = encryptData($value);
            }

            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        
        return redirect()->back()->with('success', 'Shipping method settings updated successfully')->with('method', $method);
    }
}
