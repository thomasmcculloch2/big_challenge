<?php

namespace App\Http\Controllers;

use App\Http\Requests\DownloadAttachmentRequest;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PreviewAttachmentController extends Controller
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
