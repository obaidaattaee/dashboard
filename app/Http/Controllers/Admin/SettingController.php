<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Setting;
use App\Traits\FileUpload;
use Exception;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    use FileUpload;

    public function update()
    {
        $data = request()->except(['_token', 'files']);



        if (request()->has('files') && count(request()->file('files'))) {
            foreach (request()->file('files') as $key => $value) {
                $attachment = $this->uploadFile($value);

                $attachment = Attachment::create($attachment);

                $data[$key] = $attachment['full_path'];
            }
        }

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if ($setting) {
                $setting->update([
                    'value' => $value
                ]);
            } else {
                $setting = Setting::create([
                    'key' => $key,
                    'value' => $value
                ]);
            }
        }


        Cache::flush();

        return $this->sendResponse([], t('general settings updated successfully'));
    }
    public function general()
    {
        $settings = Setting::where('group', 'general')->get();
        return view('admin.settings.index')
            ->with('settings', $settings);
    }
}
