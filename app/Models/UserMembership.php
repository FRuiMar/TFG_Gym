<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMembership extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'membership_id',
        'start_date',
        'end_date',
        'payment_status',
        'last_payment_date',
        'next_payment_date',
        'amount_paid',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'last_payment_date' => 'date',
        'next_payment_date' => 'date',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con membresía
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
