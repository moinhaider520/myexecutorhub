<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view customer profiles',
            'view bank accounts',
            'view investment accounts',
            'view properties',
            'view personal chattels',
            'view business interests',
            'view insurance policies',
            'view debt and liabilities',
            'view digital assets',
            'view intellectual properties',
            'view other assets',
            'view wishes',
            'view guidance',
            'view life remembered',
            'view advisors',
            'view executors',
            'view organs donation',
            'view voice notes',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}