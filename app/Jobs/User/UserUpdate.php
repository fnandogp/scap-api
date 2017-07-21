<?php

namespace App\Jobs\User;

use App\Repositories\UserRepository;
use App\User;

class UserUpdate
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param array $data
     */
    public function __construct(User $user, array $data)
    {
        $this->user = $user;
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
        $user = $repo->update($this->user->id, $this->data);
        
        return $user;
    }
}
