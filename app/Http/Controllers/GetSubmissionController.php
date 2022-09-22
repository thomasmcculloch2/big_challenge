<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Http\Resources\GetSubmissionResource;
use App\Http\Resources\StoreSubmissionResource;
use App\Models\Constants\Rol;
use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class GetSubmissionController extends Controller
{
    public function __invoke(): JsonResponse
    {
        /* @var User $user */
        $user = auth()->user();
        $roles = $user->getRoleNames();

        if ($roles->contains(Rol::DOCTOR)) {
            $submission = Submission::all();
            return response()->json(GetSubmissionResource::collection($submission), 201);
        } else {
            $submission = Submission::query()->where('patient',$user->id)->get();
            return response()->json(GetSubmissionResource::collection($submission), 201);
        }

    }
}
