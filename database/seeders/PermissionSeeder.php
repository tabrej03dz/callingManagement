<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'upload numbers']);
        Permission::create(['name' => 'show assign numbers']);
        Permission::create(['name' => 'show all numbers']);
        Permission::create(['name' => 'show not assigned number']);
        Permission::create(['name' => 'show all users']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'show role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'show permission']);
        Permission::create(['name' => 'assign permission']);
        Permission::create(['name' => 'show status']);
        Permission::create(['name' => 'create status']);
    }
}
