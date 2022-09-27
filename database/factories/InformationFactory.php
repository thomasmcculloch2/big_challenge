<?php

namespace Database\Factories;

use App\Models\Constant;
use App\Models\Constants\SubmissionStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Information>
 */
class InformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => User::factory()->patient()->create(),
            'phone' => '095674899',
            'weight' => '78',
            'height' => '184',
            'info' => fake()->paragraph(1),
        ];
    }
}
