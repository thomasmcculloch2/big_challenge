<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user =  User::create($request->validated());

        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }
}
