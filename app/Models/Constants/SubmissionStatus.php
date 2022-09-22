<?php

declare(strict_types=1);

namespace App\Models\Constants;

class SubmissionStatus
{
    public const SUBMISSION_STATE = [
        'PENDING' => 'pending',
        'IN_PROGRESS' => 'in progress',
        'DONE' => 'done'
    ];
}
