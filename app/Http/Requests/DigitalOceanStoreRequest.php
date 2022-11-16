<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DigitalOceanStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $submission = $this->route('submission');
        if (Gate::allows('doctorBelongsToSubmission', $submission)) {
            return true;
        }
        return false;
    }

    protected function failedAuthorization()
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
            'uploadedFile' => ['required','file','mimes:txt'],
        ];
    }
}
