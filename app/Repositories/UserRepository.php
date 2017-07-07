<?php

namespace App\Repositories;

use App\User;

class UserRepository
{

    /**
     * Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return User::query()
                   ->get();
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
        return User::query()
                   ->where('id', $id)
                   ->first();
    }

    /**
     * Get a user by email
     *
     * @param $email
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByEmail($email)
    {
        return User::query()
                   ->where('email', $email)
                   ->first();
    }
}