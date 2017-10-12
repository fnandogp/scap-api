<?php

namespace App\Jobs\User;

use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\User;

class CreateUser
{
    /**
     * @var array
     */
    private $data;


    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }


    /**
     * Execute the job.
     *
     * @param UserRepository $repo
     *
     * @return User
     */
    public function handle(UserRepository $repo)
    {
        $user = $repo->create($this->data);

        $repo = new RoleRepository();

        foreach ($this->data['roles'] as $role_name) {
            $role = $repo->findByName($role_name)
                         ->toArray();
            $user->attachRole($role);
        }

        return $user;
    }
}
