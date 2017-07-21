<?php

namespace App\Repositories;

use App\User;

class UserRepository extends BaseRepository
{
    protected $model_class = User::class;

    /**
     * Find a user by email
     *
     * @param $email
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByEmail($email)
    {
        return $this->newQuery()
                    ->where('email', $email)
                    ->first();
    }
}