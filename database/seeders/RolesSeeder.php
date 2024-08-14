<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'customer']);
        Role::create(['name' => 'partner']);
        Role::create(['name' => 'executor']);
        Role::create(['name' => 'Solicitors']);
        Role::create(['name' => 'Accountants']);
        Role::create(['name' => 'Stock Brokers']);
        Role::create(['name' => 'Will Writers']);
        Role::create(['name' => 'Financial Advisers']);        
    }
}
