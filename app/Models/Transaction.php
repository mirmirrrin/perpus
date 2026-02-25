<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'returned_at',
        'actual_return_date',
        'status',
        'rejection_reason'
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'returned_at' => 'date',
        'actual_return_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id')->withDefault([
            'name' => 'Buku Telah Dihapus'
        ]);
    }
}
