<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Rent extends Model
{
    use HasFactory;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'books_id');
    }
    protected $table = 'rents';
    protected $fillable = [
        'books_id',
        'users_id',
        'date_request',
        'date_rent',
        'date_due',
        'date_return',
        'status',
    ];
    public function getTypeAttribute()
    {
        if($this->status == null  && $this->date_request != null){
            return "pending";
        }
        //todo
        elseif($this->status == null  && $this->date_request != null){
            return "renting";
        }
        elseif($this->status == null  && $this->date_request != null){
            return "overdue";
        }
        elseif($this->status == null  && $this->date_request != null){
            return "finish";
        }
    }
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->date_request = Carbon::now();
        });
    }
}
