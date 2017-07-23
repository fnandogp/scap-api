<?php

namespace App\Repositories;

use App\Role;

class RoleRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected $model_class = Role::class;

    public function findByName($name)
    {
        return $this->newQuery()
                    ->where('name', $name)
                    ->first();
    }

}