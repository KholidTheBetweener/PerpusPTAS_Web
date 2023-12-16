<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Book;

class BookResource extends JsonResource
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
            'book_code' => $this->book_code,
            'book_title' => $this->book_title,
            'author' => $this->author,
            'category' => $this->categories->name,
            'publisher' => $this->publisher,
            'stock' => $this->stock,
            'book_cover' => $this->book_cover,
            'book_desc' => $this->book_desc,
            'barcode' => $this->book_desc,
        ];
    }
}
