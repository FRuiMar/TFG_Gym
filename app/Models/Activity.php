<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion_minutos',
        'nivel_dificultad',
        'imagen',
        'calories_burned',
        'active'
    ];

    // Relación con sesiones
    public function sessions()
    {
        return $this->hasMany(ClassSession::class);
    }

    // Entrenadores especializados en esta actividad (como primera especialidad)
    public function specialistTrainers1()
    {
        return $this->hasMany(User::class, 'specialty_1_id');
    }

    // Entrenadores especializados en esta actividad (como segunda especialidad)
    public function specialistTrainers2()
    {
        return $this->hasMany(User::class, 'specialty_2_id');
    }
}
