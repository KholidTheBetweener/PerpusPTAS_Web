<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Rent;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;
    
    public function rent(): HasMany
    {
        return $this->hasMany(Rent::class, 'books_id', 'id');
    }
    protected $fillable = [
        'book_code',
        'book_title',
        'author',
        'category',
        'publisher',
        'stock',
        'book_cover',
        'book_desc',
        'barcode',
    ];
}
