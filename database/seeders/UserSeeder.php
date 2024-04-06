<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::where('name','super_admin')-> first();
        // dd($role_admin->id);
        User::create([
            "name" => "super admin",
            "username" => "super_admin",
            "role_id" => $role_admin -> id,
            "password" => bcrypt('12345678')
        ]);
    }
}
