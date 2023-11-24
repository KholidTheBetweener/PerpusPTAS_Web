<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\BookResource;
use Illuminate\Http\JsonResponse;

class BookController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $book = Book::all();
    
        return $this->sendResponse(BookResource::collection($book), 'Books retrieved successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $book = Book::find($id);
  
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }
   
        return $this->sendResponse(new BookResource($book), 'book retrieved successfully.');
    }
    
    
}
