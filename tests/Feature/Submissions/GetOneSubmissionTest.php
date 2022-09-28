<?php

namespace Tests\Feature\Submissions;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetOneSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function testGetSubmissionSuccessfulAsPatient(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create([
            'patient_id' => $user->id
        ]);

        $response = $this->getJson(route('submission.show', "$submission->id"));
        $response->assertSuccessful();
    }

    public function testGetSubmissionSuccessfulAsDoctor(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create();

        $response = $this->getJson(route('submission.show', "$submission->id"));
        $response->assertSuccessful();
    }

    public function testGetSubmissionAsPatientNotCreatedByHim(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create();

        $response = $this->getJson(route('submission.show', "$submission->id"));
        $response->assertForbidden();
    }

    public function testGetSubmissionAsPatientThatNotExists(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->getJson(route('submission.show', 3));
        $response->assertNotFound();
    }
}
