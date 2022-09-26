<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\PatientsInfos;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PatientsInfos
 */
class PatientInfoResource extends JsonResource
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
            'phone' => $this->phone,
            'weight' => $this->weight,
            'height' => $this->height,
            'info' => $this->info,
        ];
    }
}
