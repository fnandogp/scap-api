<?php

namespace App\Jobs\User;

use App\User;

class UserUpdate
{
    /**
     * @var
     */
    private $user;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $email;
    /**
     * @var
     */
    private $enrollment;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $name, $email, $enrollment)
    {
        $this->user       = $user;
        $this->name       = $name;
        $this->email      = $email;
        $this->enrollment = $enrollment;
    }

    /**
     * Execute the job.
     *
     * @return User
     */
    public function handle()
    {
        $user = $this->user->fill([
            'name'       => $this->name,
            'email'      => $this->email,
            'enrollment' => $this->enrollment
        ]);

        return $user;
    }
}
