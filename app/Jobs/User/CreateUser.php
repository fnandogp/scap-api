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
        $this->data['password'] = bcrypt($this->data['password']);
        $user                   = $repo->create($this->data);

        $role_repo = new RoleRepository();

        foreach ($this->data['roles'] as $role_name) {
            $role = $role_repo->findByName($role_name)
                         ->toArray();
            $user->attachRole($role);
        }

        return $user;
    }
}
