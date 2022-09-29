<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DigitalOceanStoreRequest;
use App\Mail\PrescriptionAdded;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
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
        $doctor = $request->user();
        $patient = User::find($submission->patient_id);
        Mail::to($patient->email)->send(new PrescriptionAdded($submission, $patient, $doctor));
        return response()->json(['message' => 'File uploaded'], 200);
    }
}
