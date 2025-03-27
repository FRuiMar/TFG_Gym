<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trainer;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trainer::create([
            'id' => 1,
            'dni' => '12312312A',
            'first_name' => 'Pepe',
            'last_name' => 'Powers',
            'specialty' => 'Zumba y Merengue',
            'image' => null,
        ]);


        Trainer::create([
            'id' => 2,
            'dni' => '12121212A',
            'first_name' => 'Fali',
            'last_name' => 'Fortachon',
            'specialty' => 'PowerGym y Crossfit',
            'image' => null,
        ]);


        Trainer::create([
            'id' => 3,
            'dni' => '13131313A',
            'first_name' => 'Rafa',
            'last_name' => 'Rapid',
            'specialty' => 'Salsa Y Yoga',
            'image' => null,
        ]);


        Trainer::create([
            'id' => 4,
            'dni' => '14141414A',
            'first_name' => 'Manolo',
            'last_name' => 'McGym',
            'specialty' => 'Step y HIIT',
            'image' => null,
        ]);
    }
}
