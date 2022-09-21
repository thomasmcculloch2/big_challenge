<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class SubmissionController extends Controller
{
    public function store(SubmissionRequest $request): JsonResponse
    {
        $data = $request->validated();
        /* @var User $user */
        $user = auth()->user();
        $submission = Submission::create([
           'title' => $data['title'],
           'symptoms' => $data['symptoms'] ,
            'status' => 'pending',
            'patient' => $user->id
        ]);

        $response = [
            'message' => 'Submission created successfully',
            'user' => $submission,
        ];

        return response()->json($response, 201);
    }
}
