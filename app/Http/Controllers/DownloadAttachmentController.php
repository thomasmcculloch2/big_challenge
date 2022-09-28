<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DownloadAttachmentRequest;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class DownloadAttachmentController extends Controller
{
    public function __invoke(Submission $submission, DownloadAttachmentRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $file = Storage::get($submission->prescription);
        return response($file, 200);
    }
}
