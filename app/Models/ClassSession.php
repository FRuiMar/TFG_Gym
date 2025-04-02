<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSession extends Model
{
    use HasFactory, SoftDeletes;

    // Especificamos la tabla porque no sigue la convención de nombres
    //protected $table = 'class_sessions';
    //cambiado el modelo para que coincida.. borrar después de probar. 

    protected $fillable = [
        'activity_id',
        'trainer_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'capacidad_max',
        'sala',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'hora_inicio' => 'datetime',
        'hora_fin' => 'datetime',
    ];

    // Relación con actividad
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // Relación con entrenador
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    // Reservas para esta sesión
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Verificar disponibilidad
    public function isAvailable($fecha)
    {
        $count = $this->reservations()
            ->where('fecha', $fecha)
            ->whereIn('estado', ['confirmada', 'asistida'])
            ->count();

        return $count < $this->capacidad_max;
    }
}
