<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Rent;

class RentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = [
            'id' => $this->id,
            'books_id' => $this->books_id,
            'users_id' => $this->users_id,
            'date_request' => $this->date_request,
            'date_rent' => $this->date_rent,
            'date_due' => $this->date_due,
            'date_return' => $this->date_return,
            'status' => $this->status,
            'book' => $this->book,
        ];

        return $array;
    }
}
