<?php

namespace App\Jobs\User;

use App\Repositories\UserRepository;
use App\User;

class UserCreate
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

        return $user;
    }
}
