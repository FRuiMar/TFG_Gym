<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Routine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nombre'
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con ejercicios (a través de routine_exercises)
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'routine_exercises', 'rutina_id', 'ejercicio_id')
            ->withPivot('dia_semana', 'orden');
    }

    // Método para obtener ejercicios por día de la semana
    public function exercisesByDay($day)
    {
        return $this->exercises()
            ->wherePivot('dia_semana', $day)
            ->orderBy('routine_exercises.orden')
            ->get();
    }
}
