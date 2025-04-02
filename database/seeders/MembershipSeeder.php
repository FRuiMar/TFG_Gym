<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Membership;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Membership::create([
            'id' => 1,
            'name' => 'Básica',
            'description' => 'Membresía básica con acceso a instalaciones en horario limitado',
            'price' => 25.00,
            'duration_months' => 1,
            'active' => true,
        ]);

        Membership::create([
            'id' => 2,
            'name' => 'Premium',
            'description' => 'Membresía premium con acceso completo a instalaciones y clases',
            'price' => 45.00,
            'duration_months' => 1,
            'active' => true,
        ]);

        Membership::create([
            'id' => 3,
            'name' => 'Familiar',
            'description' => 'Membresía para hasta 4 miembros de la familia',
            'price' => 85.00,
            'duration_months' => 1,
            'active' => true,
        ]);

        Membership::create([
            'id' => 4,
            'name' => 'Trimestral',
            'description' => 'Membresía premium por 3 meses con descuento',
            'price' => 120.00,
            'duration_months' => 3,
            'active' => true,
        ]);

        Membership::create([
            'id' => 5,
            'name' => 'Anual',
            'description' => 'Membresía premium por 12 meses con gran descuento',
            'price' => 400.00,
            'duration_months' => 12,
            'active' => true,
        ]);
    }
}
