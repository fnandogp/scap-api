<?php

namespace App\Jobs\User;

use App\User;

class UserDelete
{
    /**
     * @var
     */
    private $user;

    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        User::destroy($this->user->id);
    }
}
