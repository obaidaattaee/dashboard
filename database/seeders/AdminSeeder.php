<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        User::truncate();
        $admin = User::create([
            'name' => 'super user',
            'email' => 'admin@mail.com',
            'password' => bcrypt(12345678),
        ]);

        $admin->syncRoles(['super_admin']);

        Schema::enableForeignKeyConstraints();
    }
}
