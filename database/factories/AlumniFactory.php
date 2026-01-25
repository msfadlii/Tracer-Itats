<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Alumni;

class AlumniFactory extends Factory
{
    protected $model = Alumni::class;

    public function definition(): array
    {
        // Nilai ENUM yang diambil langsung dari migration Anda
        $statusOptions = [
            'Bekerja (full time/part time)',
            'Belum Memungkinkan Bekerja',
            'Wiraswasta',
            'Melanjutkan Pendidikan',
            'Tidak Kerja Tetapi Sedang Mencari Kerja'
        ];

        return [
            'tahun_lulus' => $this->faker->numberBetween(2019, 2025),
            // Format NPM ITATS: 06.Tahun.1.NomerUrut
            'npm' => '06.' . $this->faker->numberBetween(2018, 2021) . '.1.' . $this->faker->unique()->numerify('0####'),
            'nama' => $this->faker->name(),
            'nik' => $this->faker->unique()->numerify('####################'), // 20 digit sesuai migration
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2002-01-01'),
            'email' => $this->faker->unique()->safeEmail(),
            'telepon' => $this->faker->phoneNumber(),
            'npwp' => $this->faker->numerify('###############'), // 15 digit default NPWP
            'dosen_pembimbing' => 'Dr. ' . $this->faker->firstName() . ' ' . $this->faker->lastName() . ', M.Kom',
            'pembiayaan' => $this->faker->randomElement(['Mandiri', 'Beasiswa Pemerintah', 'Beasiswa Perusahaan']),
            'status' => $this->faker->randomElement($statusOptions),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}