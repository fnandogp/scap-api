<?php

namespace App\Repositories;

use App\User;

class RoleRepository
{
    public function __construct()
    {
        $this->query = User::query();
    }

    /**
     * Get a role by the name
     *
     * @param $name
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($name)
    {
        return $this->query
            ->where('name', $name)
            ->get();
    }

}