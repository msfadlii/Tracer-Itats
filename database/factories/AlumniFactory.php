public function definition()
{
    return [
        'npm' => $this->faker->numerify('######'),
        'nama' => $this->faker->name(),
        'nik' => $this->faker->numerify('###############'),
        'tanggal_lahir' => '1990-01-01',
        'email' => $this->faker->unique()->safeEmail(),
        'telepon' => '08123456789',
        'status' => 'Bekerja (full time/part time)',
        'tahun_lulus' => 2020,
    ];
}
