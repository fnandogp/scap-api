<?php

namespace Tests\Feature;

use App\Repositories\UserRepository;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    /**
     * @var
     */
    protected $admin;
    /**
     * @var
     */
    protected $secretary;
    /**
     * @var
     */
    protected $professor;
    /**
     * @var
     */
    protected $department_chief;

    protected function setUp()
    {
        parent::setUp();

        $user_repo = new UserRepository;

        $this->admin            = $user_repo->findByEmail('admin@example.com');
        $this->secretary        = $user_repo->findByEmail('secretary@example.com');
        $this->professor        = $user_repo->findByEmail('professor@example.com');
        $this->department_chief = $user_repo->findByEmail('department.chief@example.com');
    }

    /**
     * @param null $user
     * @param array $custom_headers
     *
     * @return array
     */
    public function getCustomHeader($user = null, $custom_headers = [])
    {
        $headers = [
            'Accept'           => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ];

        if ( ! is_null($user)) {
            $token = \JWTAuth::fromUser($user);
            \JWTAuth::setToken($token);
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return array_merge($headers, $custom_headers);
    }
}