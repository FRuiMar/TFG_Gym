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
    public function session()
    {
        return $this->belongsTo(ClassSession::class);
    }
}
