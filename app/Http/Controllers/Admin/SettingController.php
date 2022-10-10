<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{

    public function update()
    {
        $data = request()->except('_token');

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if ($setting) {
                $setting->update([
                    'value' => $value
                ]);
            }else{
                $setting = Setting::create([
                    'key' => $key,
                    'value' => $value
                ]);
            }
        }

        Cache::flush();

        return $this->sendResponse([] , t('general settings updated successfully'));
    }
    public function general()
    {
        $settings = Setting::where('group', 'general')->get();
        return view('admin.settings.index')
            ->with('settings', $settings);
    }
}
