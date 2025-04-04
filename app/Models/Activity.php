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
    public function classSessions()
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

    // Relación con los usuarios inscritos en esta actividad
    public function users()
    {
        return $this->belongsToMany(User::class, 'activity_user', 'activity_id', 'user_id')
            ->withPivot('reservation_date')
            ->withTimestamps();
    }
}
