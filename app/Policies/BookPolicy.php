<?php

namespace App\Policies;

use App\User;
use App\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given user can delete the given book.
     *
     * @param  User  $user
     * @param  Book  $book
     * @return bool
     */
    public function destroy(User $user, Book $book)
    {
        return $user->id === $book->user_id;
    }
}
