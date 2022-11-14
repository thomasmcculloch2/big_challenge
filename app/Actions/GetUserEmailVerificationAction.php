<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;

class GetUserEmailVerificationAction
{
    public function handle(string $userId, string $hashedEmail): ?User
    {
        $user = User::find($userId);

        if (!hash_equals((string) $hashedEmail, sha1($user->getEmailForVerification()))) {
            return null;
        }

        return $user;
    }
}
