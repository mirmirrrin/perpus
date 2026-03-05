<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'author',
        'publisher',
        'category_id',
        'stock',
        'image',
        'description',
        'year'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
