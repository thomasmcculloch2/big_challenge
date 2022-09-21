<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Http\Resources\SubmissionResource;
use App\Models\Constant;
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
            'status' => Constant::SUBMISSION_STATE['PENDING'],
            'patient' => $user->id
        ]);

        $response = [
            'message' => 'Submission created successfully',
            'submission' => SubmissionResource::collection([$submission]),
        ];

        return response()->json($response, 201);
    }
}
