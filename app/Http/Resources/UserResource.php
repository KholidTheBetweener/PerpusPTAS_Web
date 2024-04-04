<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date,
            'phone' => $this->phone,
            'address' => $this->address,
            'photo' => $this->photo,
            'component' => $this->component,
        ];
    }
}
