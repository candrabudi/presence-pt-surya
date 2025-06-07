<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID'); // Gunakan locale Indonesia

        return [
            'full_name' => $faker->name(),
            'username' => $faker->unique()->userName(),
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['admin', 'employee']),
            'phone' => $faker->phoneNumber(),
            'address' => $faker->address(),
            'position' => $faker->jobTitle(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'birth_date' => $this->faker->dateTimeBetween('1993-01-01', '2004-12-31')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'last_login_at' => $this->faker->optional()->dateTime(),
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
