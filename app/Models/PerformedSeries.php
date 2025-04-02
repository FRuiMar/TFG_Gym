<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformedSeries extends Model
{
    use HasFactory;

    protected $table = 'performed_series';
    public $timestamps = false;

    protected $fillable = [
        'detalle_ejercicio_sesion_id',
        'numero_serie',
        'repeticiones',
        'peso',
        'descanso_segundos'
    ];

    // Relación con detalle de ejercicio
    public function exerciseDetail()
    {
        return $this->belongsTo(ExerciseDetail::class, 'detalle_ejercicio_sesion_id');
    }
}
