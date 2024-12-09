<?php

namespace Database\Factories;

use App\Models\Doctores;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctoresFactory extends Factory
{
    protected $model = Doctores::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'especialidad' => $this->faker->word,
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'direccion' => $this->faker->address,
        ];
    }
}