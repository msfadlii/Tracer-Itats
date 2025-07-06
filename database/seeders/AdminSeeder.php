<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin_ITATS',
            'email' => 'admin@itats.ac.id',
            'password' => Hash::make('admin'),
        ]);
    }
}
