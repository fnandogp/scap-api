<?php

namespace Tests\Feature;

use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    /**
     * @var
     */
    protected $admin;

    public function setUp()
    {
        parent::setUp();

        $this->admin = factory(\App\User::class)->create(
            ['password' => 'secret']
        );
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