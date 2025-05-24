<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'type' => 'Administrateur',
            'nom' => 'Admin',
            'email' => 'admin@travelcar225.com',
            'contact_telephone' => '0708339194',
            'password' => Hash::make('password'),
            'role' => 'Administrateur',
        ]);
    }
}