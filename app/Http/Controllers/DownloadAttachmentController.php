<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DownloadAttachmentRequest;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class DownloadAttachmentController extends Controller
{
    public function __invoke(Submission $submission)
    {
        $path = Storage::get($submission->prescription);
        $headers = [
            'Content-Type' => 'application/plain',
            'Content-Descrption' => 'File Transfer',
        ];
        return response()->make($path, 200, $headers);
    }

}
