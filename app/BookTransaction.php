<?php

namespace App;

use App\User;
use App\Book;
use Illuminate\Database\Eloquent\Model;

class BookTransaction extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //protected $table = 'book_transactions';

    protected $fillable = ['userId', 'bookId', 'penalty', 'dateBorrowed', 'dateReturned'];

    /**
     * Get the user that owns the transasction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that owns the transasction.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }



}
