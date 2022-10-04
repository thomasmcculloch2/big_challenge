<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Constants\Rol;
use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetSubmissionController
{
    public function __invoke(): JsonResponse
    {
        $user = Auth::user();
        if ($user->hasRole(Rol::DOCTOR)) {
            $submission = Submission::query()->where('status', SubmissionStatus::PENDING)->orWhere('doctor_id', $user->id)->get();
            return response()->json(SubmissionResource::collection($submission), 201);
        }
            $submission = $user->submissions;
            return response()->json(SubmissionResource::collection($submission), 201);
    }
}
