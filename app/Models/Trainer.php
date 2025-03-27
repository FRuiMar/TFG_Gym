<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'dni',
        'first_name',
        'last_name',
        'specialty',
        'image',
    ];

    // Relación con actividades
    public function activities()
    {
        return $this->hasMany(Activity::class, 'trainer_id');
    }
}
