<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'type' => 'Mensual',
            'price' => 45,
            'duration_months' => 1,
        ]);

        Membership::create([
            'id' => 2,
            'type' => 'Trimestral',
            'price' => 120,
            'duration_months' => 3,
        ]);

        Membership::create([
            'id' => 3,
            'type' => 'Anual',
            'price' => 450,
            'duration_months' => 12,
        ]);

        Membership::create([
            'id' => 4,
            'type' => 'Mensual Tarde',
            'price' => 25,
            'duration_months' => 1,
        ]);

        Membership::create([
            'id' => 5,
            'type' => 'Mensual Mañana',
            'price' => 20,
            'duration_months' => 1,
        ]);
    }
}
