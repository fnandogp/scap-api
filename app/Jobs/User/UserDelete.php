<?php

namespace App\Jobs\User;

use App\Repositories\UserRepository;
use App\User;

class UserDelete
{
    /**
     * @var
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param UserRepository $repo
     */
    public function handle(UserRepository $repo)
    {
        $repo->delete($this->user->id);
    }
}
