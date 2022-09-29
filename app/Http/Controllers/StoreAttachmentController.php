<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DigitalOceanStoreRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreAttachmentController extends Controller
{
    public function __invoke(DigitalOceanStoreRequest $request, Submission $submission): JsonResponse
    {
        $file = $request->file('uploadedFile');
        $name = (string) Str::uuid();
        $fileName = $name . '.txt';
        $folder = config('filesystems.disks.do.folder');
        $path = Storage::putFileAs($folder, $file, $fileName, 'public');
        $submission->prescription = $path;
        $submission->save();
        return response()->json(['message' => 'File uploaded'], 200);
    }
}
