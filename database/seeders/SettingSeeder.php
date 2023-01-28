<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['name' => 'App Name', 'key' => 'app_name', 'value' => 'Sanapix Subsriptions System', 'group' => 'general', 'type' => 'text', 'can_change' => true],
            ['name' => 'About', 'key' => 'about', 'value' => 'Manage the clients and subscriptions.', 'group' => 'general', 'type' => 'textarea', 'can_change' => true],
            ['name' => 'App Logo', 'key' => 'app_logo', 'value' => asset('admin_assets/assets/img/default_logo.png'), 'group' => 'general', 'type' => 'file', 'can_change' => true],
        ];

        Cache::forget('settings');
        Setting::truncate();
        Setting::insert($settings);
    }
}
