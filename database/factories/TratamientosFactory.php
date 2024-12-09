<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tratamientos>
 */
class TratamientosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo_tratamiento' => $this->faker->word(),
            'costo' => $this->faker->randomFloat(2, 0, 1000),
            'duración' => $this->faker->numberBetween(1, 100),
            'doctor_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
