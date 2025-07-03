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
            'name' => 'Pandu Alumni',
            'email' => 'admin@itats.ac.id',
            'password' => Hash::make('admin'),
        ]);
    }
}
