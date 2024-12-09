<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctores extends Model
{
    /** @use HasFactory<\Database\Factories\DoctoresFactory> */
    use HasFactory;
    protected $fillable = ['nombre', 'apellido', 'especialidad', 'telefono', 'email', 'direccion'];

}
