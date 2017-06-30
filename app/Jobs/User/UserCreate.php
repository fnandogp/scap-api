<?php

namespace App\Jobs\User;

use App\User;

class UserCreate
{
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
    private $password;
    /**
     * @var
     */
    private $enrollment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $email, $password, $enrollment)
    {
        $this->name       = $name;
        $this->email      = $email;
        $this->password   = $password;
        $this->enrollment = $enrollment;
    }

    /**
     * Execute the job.
     *
     * @return \App\User
     */
    public function handle()
    {
        $user = User::create([
            'name'       => $this->name,
            'email'      => $this->email,
            'password'   => \Hash::make($this->password),
            'enrollment' => $this->enrollment
        ]);

        return $user;
    }
}
