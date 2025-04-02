<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipBenefit extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id',
        'tipo_beneficio',
        'nombre',
        'valor',
        'descripcion',
        'active'
    ];

    // Relación con membresía
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
