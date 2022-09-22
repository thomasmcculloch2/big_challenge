<?php

namespace Database\Factories;

use App\Models\Constant;
use App\Models\Constants\SubmissionStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->name(),
            'symptoms' => fake()->paragraph(1) ,
            'status' => SubmissionStatus::SUBMISSION_STATE['PENDING'],
            'patient' => User::factory()->create()
        ];
    }
}
