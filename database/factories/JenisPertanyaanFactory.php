<?php

namespace Database\Factories;

use App\Models\JenisPertanyaan;
use Illuminate\Database\Eloquent\Factories\Factory;

class JenisPertanyaanFactory extends Factory
{
    protected $model = JenisPertanyaan::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->words(2, true),
        ];
    }
}
