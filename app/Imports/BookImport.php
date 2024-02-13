<?php

namespace App\Imports;

use Illuminate\Support\Collection;
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
            'column1' => $row[0],
            'column2' => $row[1],
            // Add more columns as needed
        ]);
    }
}
