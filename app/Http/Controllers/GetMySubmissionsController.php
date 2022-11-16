<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Constants\Rol;
use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetMySubmissionsController
{
    public function __invoke(): JsonResponse
    {
        $user = Auth::user();
//        if ($user->hasRole(Rol::DOCTOR)) {
//            $submission = Submission::query()->where('status', SubmissionStatus::IN_PROGRESS)->orWhere('status', SubmissionStatus::DONE)->get();
//            return response()->json(SubmissionResource::collection($submission), 201);
//        }
            $submission = $user->submissions;
            return response()->json(SubmissionResource::collection($submission), 201);
    }
}
