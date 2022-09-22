<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Http\Resources\StoreSubmissionResource;
use App\Models\Constants\Rol;
use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class StoreSubmissionController extends Controller
{
    public function __invoke(SubmissionRequest $request): JsonResponse
    {
        $data = $request->validated();
        /* @var User $user */
        $user = auth()->user();
        $submission = Submission::create([
           'title' => $data['title'],
           'symptoms' => $data['symptoms'] ,
            'status' => SubmissionStatus::PENDING,
            'patient' => $user->id
        ]);

        $response = [
            'message' => 'Submission created successfully',
            'submission' => StoreSubmissionResource::make($submission),
        ];

        return response()->json($response, 201);
    }


}
