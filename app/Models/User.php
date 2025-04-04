<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Activity;
use App\Models\ClassSession;
use App\Models\Membership;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'dni',
        'name',
        'surname',
        'surname2',
        'email',
        'password',
        'role',
        'sexo',
        'weight',
        'height',
        'birth_date',
        'phone',
        'emergency_contact',
        'health_conditions',
        'specialty_1_id',
        'specialty_2_id',
        'notifications_enabled',
        'image',
        'membership_id',
        'active',
    ];

    // Campos ocultos (no los incluyo en las respuestas JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación muchos a muchos con actividades (a través de la tabla pivote activity_user)
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_user', 'user_id', 'activity_id')
            ->withPivot('reservation_date');
    }


    // Historial de membresías
    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    // Relación con Membership actual para mayor claridad
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    // Rutinas del usuario
    public function routines()
    {
        return $this->hasMany(Routine::class);
    }

    // Sesiones de entrenamiento registradas
    public function workoutSessions()
    {
        return $this->hasMany(WorkoutSession::class);
    }

    // Reservas del usuario
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Sesiones que imparte (para entrenadores)
    public function classSessions()
    {
        return $this->hasMany(ClassSession::class, 'trainer_id');
    }

    // Convertir fecha de nacimiento a Carbon
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
    ];


    //Relación  con especialidades
    public function specialty1()
    {
        return $this->belongsTo(Activity::class, 'specialty_1_id');
    }

    public function specialty2()
    {
        return $this->belongsTo(Activity::class, 'specialty_2_id');
    }
}
