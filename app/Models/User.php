<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Activity;
use App\Models\Membership;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'dni',
        'name',
        'email',
        'password',
        'role',
        'image',
        'membership_id',
    ];

    // Campos ocultos (no se incluyen en las respuestas JSON)
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

    // Relación con membresías
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }
}
