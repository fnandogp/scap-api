<?php

namespace Tests\Unit;

use App\Jobs\RemovalRequest\RemovalRequestCreate;
use App\RemovalRequest;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RemovalRequestTest extends TestCase
{
    use DatabaseMigrations;

    private $removal_request;
    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->removal_request = create(RemovalRequest::class);
        $this->user            = create(User::class);
    }

    /** @test */
    public function a_request_has_a_user()
    {
        $this->assertInstanceOf(User::class, $this->removal_request->user);
    }

    /** @test */
    function a_national_request_starts_with_the_released_status()
    {
        $data = make(RemovalRequest::class, ['user_id' => $this->user->id, 'type' => 'national'])->toArray();

        $request = dispatch(new RemovalRequestCreate($data));

        $this->assertEquals('released', $request->status);
    }

    /** @test */
    function a_international_request_starts_with_the_initial_status()
    {
        $data = make(RemovalRequest::class, ['user_id' => $this->user->id, 'type' => 'international'])->toArray();

        $request = dispatch(new RemovalRequestCreate($data));

        $this->assertEquals('initial', $request->status);
    }
}
