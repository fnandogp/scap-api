<?php

namespace Tests\Unit;

use App\Jobs\Request\RequestCreate;
use App\Request;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    private $request;
    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->request = create(Request::class);
        $this->user    = create(User::class);
    }

    /** @test */
    public function a_request_has_a_user()
    {
        $this->assertInstanceOf(User::class, $this->request->user);
    }

    /** @test */
    function a_national_request_starts_with_the_released_status()
    {
        $data = make(Request::class, ['user_id' => $this->user->id, 'type' => 'national'])->toArray();

        $request = dispatch(new RequestCreate($data));

        $this->assertEquals('released', $request->status);
    }

    /** @test */
    function a_international_request_starts_with_the_initial_status()
    {
        $data = make(Request::class, ['user_id' => $this->user->id, 'type' => 'international'])->toArray();

        $request = dispatch(new RequestCreate($data));

        $this->assertEquals('initial', $request->status);
    }
}
