<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(
            ['name' => 'member'],
            ['description' => 'Member/Peserta']
        );

        Role::firstOrCreate(
            ['name' => 'event_organizer'],
            ['description' => 'Penyelenggara Event']
        );

        Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrator']
        );
    }
}
