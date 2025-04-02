<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoría',
        'muscle_groups',
        'equipment_needed',
        'imagen',
        'video_url',
        'instrucciones'
    ];

    // Relación con rutinas (a través de routine_exercises)
    public function routines()
    {
        return $this->belongsToMany(Routine::class, 'routine_exercises', 'ejercicio_id', 'rutina_id')
            ->withPivot('dia_semana', 'orden');
    }

    // Relación con detalles en sesiones de entrenamiento
    public function exerciseDetails()
    {
        return $this->hasMany(ExerciseDetail::class, 'ejercicio_id');
    }
}
