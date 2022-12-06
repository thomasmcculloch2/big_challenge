<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'id' => $this->id,
            'email_verified_at' => $this->email_verified_at,
            'info' => PatientInfoResource::make($this->information),
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}
