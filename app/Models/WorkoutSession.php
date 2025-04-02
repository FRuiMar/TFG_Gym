<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkoutSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'fecha',
        'notas'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con detalles de ejercicios
    public function exerciseDetails()
    {
        return $this->hasMany(ExerciseDetail::class);
    }

    // Método para obtener ejercicios ordenados
    public function orderedExercises()
    {
        return $this->exerciseDetails()->orderBy('orden')->with('exercise')->get();
    }
}
