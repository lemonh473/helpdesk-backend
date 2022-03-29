<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Facades\App\Services\UserRoleService;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);

        UserRoleService::setRole($user, 1);
    }
}
