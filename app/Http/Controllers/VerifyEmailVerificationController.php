<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class VerifyEmailVerificationController extends Controller
{
    private Dispatcher $dispatcher;

    public function __construct()
    {
        $this->dispatcher = new Dispatcher();
    }

    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified']);
        }

        if ($request->user()->markEmailAsVerified()) {
            $this->dispatcher->dispatch(new Verified($request->user()));
        }

        return response()->json(['message' => 'Email has been verified']);
    }
}
