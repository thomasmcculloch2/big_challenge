<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\PatientsInfos;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'id' => $this->id,
            'info' => PatientInfoResource::make(PatientsInfos::where('patient_id', $this->id)->first()),
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}
