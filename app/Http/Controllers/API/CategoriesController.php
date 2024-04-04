<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\CategoriesResource;
use Illuminate\Http\JsonResponse;

class CategoriesController extends BaseController
{
    public function index(): JsonResponse
    {
        $category = Categories::all();
    
        return $this->sendResponse(CategoriesResource::collection($category), 'Categories retrieved successfully.');
    }
}
