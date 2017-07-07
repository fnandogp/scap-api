<?php

namespace Tests\Feature;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{

    use DatabaseMigrations;

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

    public function setUp()
    {
        parent::setUp();

        $this->seed(\InitSeeder::class);

        $user_repo = new UserRepository;

        $this->admin     = $user_repo->getByEmail('admin@example.com');
        $this->secretary = $user_repo->getByEmail('secretary@example.com');
        $this->professor = $user_repo->getByEmail('professor@example.com');
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