<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailNewPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class SendEmailNewPasswordController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(SendEmailNewPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => __($status)
            ]);
        }

        return response()->json([
            'message' => __($status)
        ]);
    }
}
