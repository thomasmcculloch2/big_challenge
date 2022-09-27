<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class StoreSubmissionController
{
    public function __invoke(SubmissionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $request->user();
        $submission = Submission::create([
           'title' => $data['title'],
           'symptoms' => $data['symptoms'] ,
            'status' => SubmissionStatus::PENDING,
            'patient' => $user->id,
            'doctor' => NULL
        ]);

        $response = [
            'message' => 'Submission created successfully',
            'submission' => SubmissionResource::make($submission),
        ];

        return response()->json($response, 201);
    }
}
