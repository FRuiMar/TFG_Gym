<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'type',
        'price',
        'duration_months',
    ];

    // Relación con usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'membership_id');
    }
}
