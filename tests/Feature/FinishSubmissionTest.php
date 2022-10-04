<?php

namespace Tests\Feature;

use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use App\Models\User;
use Tests\TestCase;

class FinishSubmissionTest extends TestCase
{
    public function testFinishSubmissionSuccessful(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create([
            'doctor_id' => $user->id,
            'status' => SubmissionStatus::IN_PROGRESS
        ]);

        $response = $this->postJson(route('submission.finish', "$submission->id"));
        $response->assertSuccessful();
    }

    public function testFinishSubmissionUnsuccessful(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create([
            'status' => SubmissionStatus::IN_PROGRESS
        ]);

        $response = $this->postJson(route('submission.finish', "$submission->id"));
        $response->assertForbidden();
    }

    public function testFinishSubmissionAsPatient(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create([
            'status' => SubmissionStatus::IN_PROGRESS
        ]);

        $response = $this->postJson(route('submission.finish', "$submission->id"));
        $response->assertForbidden();
    }
}
