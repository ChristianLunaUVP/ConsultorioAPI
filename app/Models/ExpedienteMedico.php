<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedienteMedico extends Model
{
    use HasFactory;

    protected $table = 'expedientes_medicos'; // Asegúrate de que el nombre de la tabla es correcto

    protected $fillable = [
        'imagen',
        'fecha',
        'doctor_id',
        'diagnostico',
    ];

    // Relación con Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}