<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipBenefit;

class MembershipBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Beneficios para membresía Básica (id: 1)
        MembershipBenefit::create([
            'membership_id' => 1,
            'benefit_type' => 'acceso',
            'name' => 'Acceso sala fitness',
            'value' => 'Incluido',
            'description' => 'Acceso completo a la sala de fitness con equipamiento de musculación y cardio',
            'active' => true,
        ]);

        MembershipBenefit::create([
            'membership_id' => 1,
            'benefit_type' => 'horario',
            'name' => 'Horario limitado',
            'value' => '9:00-16:00',
            'description' => 'Acceso en horario reducido de lunes a viernes',
            'active' => true,
        ]);

        // Beneficios para membresía Premium (id: 2)
        MembershipBenefit::create([
            'membership_id' => 2,
            'benefit_type' => 'acceso',
            'name' => 'Acceso sala fitness',
            'value' => 'Incluido',
            'description' => 'Acceso completo a la sala de fitness con equipamiento de musculación y cardio',
            'active' => true,
        ]);

        MembershipBenefit::create([
            'membership_id' => 2,
            'benefit_type' => 'horario',
            'name' => 'Horario completo',
            'value' => '07:00-23:00',
            'description' => 'Acceso en horario completo de lunes a domingo',
            'active' => true,
        ]);

        MembershipBenefit::create([
            'membership_id' => 2,
            'benefit_type' => 'clases',
            'name' => 'Clases colectivas',
            'value' => 'Ilimitadas',
            'description' => 'Acceso a todas las clases colectivas sin coste adicional',
            'active' => true,
        ]);

        MembershipBenefit::create([
            'membership_id' => 2,
            'benefit_type' => 'extras',
            'name' => 'Invitados',
            'value' => '2 por mes',
            'description' => 'Posibilidad de traer invitados dos veces al mes',
            'active' => true,
        ]);

        // Beneficios para membresía Familiar (id: 3)
        MembershipBenefit::create([
            'membership_id' => 3,
            'benefit_type' => 'acceso',
            'name' => 'Acceso familiar',
            'value' => 'Hasta 4 miembros',
            'description' => 'Acceso para hasta 4 miembros de la familia',
            'active' => true,
        ]);

        MembershipBenefit::create([
            'membership_id' => 3,
            'benefit_type' => 'horario',
            'name' => 'Horario completo',
            'value' => '07:00-23:00',
            'description' => 'Acceso en horario completo de lunes a domingo',
            'active' => true,
        ]);

        MembershipBenefit::create([
            'membership_id' => 3,
            'benefit_type' => 'clases',
            'name' => 'Clases colectivas',
            'value' => 'Ilimitadas',
            'description' => 'Acceso a todas las clases colectivas sin coste adicional',
            'active' => true,
        ]);
    }
}
