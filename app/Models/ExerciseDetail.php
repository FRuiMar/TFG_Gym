<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseDetail extends Model
{
    use HasFactory;

    protected $table = 'exercise_details';
    public $timestamps = false;

    protected $fillable = [
        'workout_session_id',
        'ejercicio_id',
        'orden',
        'notas'
    ];

    // Relación con sesión de entrenamiento
    public function workoutSession()
    {
        return $this->belongsTo(WorkoutSession::class);
    }

    // Relación con ejercicio
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'ejercicio_id');
    }

    // Relación con series realizadas
    public function performedSeries()
    {
        return $this->hasMany(PerformedSeries::class, 'detalle_ejercicio_sesion_id');
    }
}
