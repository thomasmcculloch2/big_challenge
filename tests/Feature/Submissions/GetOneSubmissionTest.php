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

        $submission = Submission::factory()->create();

        $response = $this->getJson(route('submission.index', "$submission->id"));
        $response->assertSuccessful();
    }

    public function testGetSubmissionSuccessfulAsDoctor(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create();

        $response = $this->getJson(route('submission.index', "$submission->id"));
        $response->assertSuccessful();
    }
}
