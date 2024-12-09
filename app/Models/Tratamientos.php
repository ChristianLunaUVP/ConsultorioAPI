<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamientos extends Model
{
    /** @use HasFactory<\Database\Factories\TratamientosFactory> */
    use HasFactory;
    protected $fillable = ['tipo_tratamiento', 'costo', 'duración', 'doctor_id'];
}

