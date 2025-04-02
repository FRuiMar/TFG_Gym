<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_months',
        'active'
    ];

    // Relación con usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'membership_id');
    }

    // Relación con beneficios
    public function benefits()
    {
        return $this->hasMany(MembershipBenefit::class);
    }

    // Relación con historial de membresías de usuarios
    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class);
    }
}
