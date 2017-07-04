<?php

namespace App\Repositories\User;

use App\User;

class UserEloquent
{
    public function __construct()
    {
        $this->query = User::query();
    }

    /**
     * @see UserRepository::getAll()
     */
    public function getAll()
    {
        return $this->query->get();
    }
}