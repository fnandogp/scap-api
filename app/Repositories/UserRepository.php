<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    public function __construct()
    {
        $this->query = User::query();
    }

    /**
     * Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->query->get();
    }

    /**
     * Find a single user
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($id)
    {
        return $this->query->where('id', $id)->get();
    }
}