<?php

namespace Tests\Unit;

use App\Request;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    private $request;

    protected function setUp()
    {
        parent::setUp();

        $this->request = create(Request::class);
    }

    /** @test */
    public function a_request_has_a_user()
    {
        $this->assertInstanceOf(User::class, $this->request->user);
    }
}
