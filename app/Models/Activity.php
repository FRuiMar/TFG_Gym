<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Activity extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'schedule',
        'max_capacity',
        'trainer_id',
        'image',
    ];

    // Relación muchos a muchos con usuarios (a través de la tabla pivote activity_user)
    public function users()
    {
        return $this->belongsToMany(User::class, 'activity_user', 'activity_id', 'user_id')
            ->withPivot('reservation_date');
    }

    // Relación con entrenadores
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
}
