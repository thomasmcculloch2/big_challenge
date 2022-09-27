<?php

namespace Database\Factories;

use App\Models\Constants\Rol;
use App\Models\Information;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(10)),
            'remember_token' => Str::random(10),
        ];
    }

    public function patient() {
        return $this->afterCreating(function(User $user) {
            try {
                Role::create(['name' => Rol::PATIENT]);
            } catch (RoleAlreadyExists $e) {
                // DO nothing
            }
            $user->assignRole(Rol::PATIENT);
        });
    }

    public function WithInInformation() {
        return $this->afterCreating(function(User $user) {
            Information::factory()->create([
                'patient_id' => $user->id,
            ]);
        });
    }


    public function doctor() {
        return $this->afterCreating(function(User $user) {
            try {
                Role::create(['name' => Rol::DOCTOR]);
            } catch (RoleAlreadyExists $e) {
                // DO nothing
            }
            $user->assignRole(Rol::DOCTOR);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
