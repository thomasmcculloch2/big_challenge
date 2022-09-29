<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DownloadAttachmentRequest;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class DownloadAttachmentController extends Controller
{
    public function __invoke(Submission $submission, DownloadAttachmentRequest $request): \Illuminate\Http\JsonResponse
    {
        $file = Storage::get($submission->prescription);
        $response = [
            'message' => 'Download successful',
            'file' => $file
        ];
        return response()->json($response, 200);
    }
}
