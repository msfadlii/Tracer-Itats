<?php

namespace Database\Factories;

use App\Models\HalamanKuesioner;
use Illuminate\Database\Eloquent\Factories\Factory;

class HalamanKuesionerFactory extends Factory
{
    protected $model = HalamanKuesioner::class;

    public function definition()
    {
        return [
            'judul'      => $this->faker->sentence(3),
            'deskripsi'  => $this->faker->sentence(8),
            'urutan'     => $this->faker->numberBetween(1, 20),
        ];
    }
}
