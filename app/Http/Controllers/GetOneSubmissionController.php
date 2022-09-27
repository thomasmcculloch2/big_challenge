<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\OneSubmissionResource;
use App\Http\Resources\SubmissionResource;
use App\Models\Constants\Rol;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetOneSubmissionController
{
    public function __invoke(Submission $submission): JsonResponse
    {
        $user = Auth::user();
        if ($user->hasRole(Rol::PATIENT)) {
            if ($submission->patient == $user->id) {
                return response()->json(SubmissionResource::make($submission), 201);
            }
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json(OneSubmissionResource::make($submission), 201);
    }
}
