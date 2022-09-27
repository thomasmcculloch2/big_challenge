<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Constants\Rol;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class UserPolicy
{
    use HandlesAuthorization;

    public function canGetOneSubmission(User $user, Submission $submission): Response
    {
        if ($user->hasRole(Rol::DOCTOR)) {
            return Response::allow();
        }
        return $user->id === $submission->patient ? Response::allow() : Response::deny('error');
    }
}
