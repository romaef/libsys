<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
     * Get all of the users.
     *
     * @return Collection
     */
    public function all()
    {
        return User::orderBy('name', 'asc')
                    ->get();
    }
}