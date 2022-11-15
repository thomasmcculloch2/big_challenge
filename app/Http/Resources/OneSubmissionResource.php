<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Submission;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Submission
 */
class OneSubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'doctor' => DoctorResource::make($this->doctor),
            'symptoms' => $this->symptoms,
            'status' => $this->status,
            'patient' => UserResource::make($this->patient),
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}
