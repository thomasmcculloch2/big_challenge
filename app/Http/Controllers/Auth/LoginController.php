<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class LoginController
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $data =  $request->validated();

        $user = User::where('email',$data['email'])->first();

        if (!$user || !Hash::check($data['password'],$user->password))  { //@TODO convert the password into a hash value in resgisterController when creating a user
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }
        $token = $user->createToken('userToken')->plainTextToken;
        $response = [
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ];

            return response()->json($response, 201);
        }
}
