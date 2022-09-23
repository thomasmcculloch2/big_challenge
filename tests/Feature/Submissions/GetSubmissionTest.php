<?php

namespace Tests\Feature\Submissions;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function testGetSubmissionSuccessfulAsPatient(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->getJson(route('submission.index'));
        $response->assertSuccessful()
            ->assertJsonStructure([

            ]);
    }

    public function testGetSubmissionSuccessfulAsDoctor(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $response = $this->getJson(route('submission.index'))->assertSuccessful();
    }

    public function testGetSubmissionNotLogged(): void
    {
        $response = $this->getJson(route('submission.index'))->assertUnauthorized();
    }
}
