<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Membership;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    // protected static ?string $password;  // voy a usar 12345 por defecto

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Género aleatorio: Hombre, Mujer o No Contesta
        $gender = $this->faker->randomElement(['H', 'M', 'NC']);

        return [
            'dni' => $this->faker->unique()->numerify('########') . $this->faker->randomLetter(),
            'name' => $this->faker->firstName($gender === 'H' ? 'male' : ($gender === 'M' ? 'female' : null)),
            'surname' => $this->faker->lastName(),
            'surname2' => $this->faker->optional(0.7)->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'NORMAL', // Solo usuarios normales
            'sexo' => $gender,
            'weight' => $this->faker->optional(0.8)->randomFloat(2, 50, 120),
            'height' => $this->faker->optional(0.8)->randomFloat(2, 1.50, 2.10),
            'birth_date' => $this->faker->dateTimeBetween('-70 years', '-16 years')->format('Y-m-d'),
            'phone' => $this->faker->optional(0.9)->numerify('6########'),
            'emergency_contact' => $this->faker->optional(0.6)->name() . ': ' . $this->faker->numerify('6########'),
            'health_conditions' => $this->faker->optional(0.3)->sentence(),
            'specialty_1_id' => null, // Usuarios normales no tienen especialidad
            'specialty_2_id' => null, // Usuarios normales no tienen especialidad
            'notifications_enabled' => $this->faker->boolean(80), // 80% tienen notificaciones activadas
            'image' => null,
            'membership_id' => function () {
                // Asegúrate de importar el modelo Membership en la parte superior
                return Membership::where('active', true)->inRandomOrder()->first()?->id;
            },
            'active' => $this->faker->boolean(90), // 90% de usuarios activos
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
