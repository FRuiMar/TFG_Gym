<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoutineExercise extends Pivot
{
    use HasFactory;

    protected $table = 'routine_exercises';

    protected $fillable = [
        'rutina_id',
        'ejercicio_id',
        'dia_semana',
        'orden'
    ];

    // Relación con rutina
    public function routine()
    {
        return $this->belongsTo(Routine::class, 'rutina_id');
    }

    // Relación con ejercicio
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'ejercicio_id');
    }
}
