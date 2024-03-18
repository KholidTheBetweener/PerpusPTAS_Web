<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;

class BookImport implements ToModel
{
    /**
    * @param Book $book
    */
    public function model(array $row)
    {
        // Define how to create a model from the Excel row data
        return new Book([
            'category' => $row[0],
            'book_code' => $row[1],
            'book_title' => $row[2],
            'author' => $row[3],
            'publisher' => $row[4],
            'book_desc' => $row[5],
            'stock' => $row[6],
        ]);
    }
}
