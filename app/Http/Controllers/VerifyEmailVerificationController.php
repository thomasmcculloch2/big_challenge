<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\GetUserEmailVerificationAction;
use Illuminate\Auth\Events\Verified;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class VerifyEmailVerificationController
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(string $userId, string $hashedEmail, GetUserEmailVerificationAction $action): JsonResponse
    {
        $user = $action->handle($userId, $hashedEmail);
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified']);
        }

        if ($user->markEmailAsVerified()) {
            $this->dispatcher->dispatch(new Verified($user));
        }

        return response()->json(['message' => 'Email has been verified']);
    }
}
