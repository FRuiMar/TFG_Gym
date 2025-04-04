<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'session_id',
        'fecha',
        'estado',
        'check_in_time'
    ];

    protected $casts = [
        'fecha' => 'date',
        'check_in_time' => 'datetime',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con sesión
    public function classSession()
    {
        return $this->belongsTo(ClassSession::class, 'session_id');
    }



    // Verificar si la reserva está confirmada
    public function isConfirmed()
    {
        return $this->estado === 'confirmada';
    }

    // Verificar si la reserva fue cancelada
    public function isCancelled()
    {
        return $this->estado === 'cancelada';
    }

    // Verificar si el usuario asistió
    public function hasAttended()
    {
        return $this->estado === 'asistida' || $this->check_in_time !== null;
    }


    //Si necesito acceder a la actividad con frecuencia
    // Acceso directo a la actividad
    public function activity()
    {
        return $this->hasOneThrough(
            Activity::class,
            ClassSession::class,
            'id',           // PK en ClassSession
            'id',           // PK en Activity
            'session_id',   // FK en Reservation que apunta a ClassSession
            'activity_id'   // FK en ClassSession que apunta a Activity
        );
    }
}
