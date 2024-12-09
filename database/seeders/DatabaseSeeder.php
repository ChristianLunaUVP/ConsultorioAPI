<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tratamientos;
use App\Models\Pacientes;
use App\Models\Doctores;
use App\Models\Citas;
use App\Models\ExpedienteMedico;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Doctores::factory(10)->create();
        Pacientes::factory(40)->create();
        Citas::factory(50)->create();
        Tratamientos::factory(30)->create();      
        ExpedienteMedico::factory(50)->create();

    }
}
