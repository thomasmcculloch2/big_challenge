<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Submission;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DownloadAttachmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /** @var Submission $submission */
        $submission = $this->route('submission');
        if ($submission->prescription && (Gate::allows('doctorBelongsToSubmission', $submission) || Gate::allows('patientBelongsToSubmission', $submission))) {
            return true;
        }
        return false;
    }

    protected function failedAuthorization() : AuthorizationException
    {
        throw new AuthorizationException('You are not authorize to download this attachment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
