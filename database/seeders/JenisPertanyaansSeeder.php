<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPertanyaansSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'textarea', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'select', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'radio', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'checkbox', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'scale', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'matrix', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('jenis_pertanyaans')->insert($data);
    }
}
