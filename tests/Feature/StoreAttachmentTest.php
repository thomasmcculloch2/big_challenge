<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreAttachmentTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreAttachmentSuccessfully(): void
    {
        $submission = Submission::factory()->withDoctor()->create();
        $this->actingAs($submission->doctor);

        Storage::fake();

        $response = $this->postJson(route('submission.upload', "$submission->id"), [
            'uploadedFile' => UploadedFile::fake()->create('text.txt')
        ]);
        $submission->refresh();
        Storage::assertExists($submission->prescription);
    }

    public function testStoreAttachmentUnsuccessfully(): void
    {
        $user = User::factory()->doctor()->create();
        $submission = Submission::factory()->withDoctor()->create();
        $this->actingAs($user);

        Storage::fake();

        $response = $this->postJson(route('submission.upload', "$submission->id"), [
            'uploadedFile' => UploadedFile::fake()->create('text.txt')
        ])->assertForbidden();
    }
}
