<?php

namespace Database\Factories;

use App\Models\ExpedienteMedico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExpedienteMedico>
 */
class ExpedienteMedicoFactory extends Factory
{
    protected $model = ExpedienteMedico::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'imagen' => $this->faker->imageUrl(),
            'fecha' => $this->faker->date(),
            'doctor_id' => \App\Models\Doctores::inRandomOrder()->first()->id, // Asegúrate de que el doctor_id existe
            'diagnostico' => $this->faker->sentence(),
        ];
    }
}