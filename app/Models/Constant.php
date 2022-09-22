<?php

declare(strict_types=1);

namespace App\Models;

class Constant
{
    public const SUBMISSION_STATE = [
        'PENDING' => 'pending',
        'IN_PROGRESS' => 'in progress',
        'DONE' => 'done'
    ];

    public const USER_TYPE = [
        'DOCTOR' => 'doctor',
        'PATIENT' => 'patient',
    ];
}
