<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Constants\Rol;
use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GetMySubmissionsController
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($request->status) {
            $submissions = $user->submissions()->where('status',$request->status)->paginate();
        } else {
            $submissions = $user->submissions()->paginate();
        }
        return response()->json(SubmissionResource::collection($submissions)->response()->getData(true));
    }
}
