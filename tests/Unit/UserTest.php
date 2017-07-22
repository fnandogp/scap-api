<?php

namespace Tests\Unit;

use App\Mandate;
use App\RemovalRequest;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = create(User::class);
    }

    /** @test */
    function a_user_can_make_removal_requests()
    {
        create(RemovalRequest::class, ['user_id' => $this->user->id], 3);

        $this->assertEquals(3, $this->user->removalRequests->count());
    }

    /** @test */
    function a_user_can_have_a_mandate()
    {
        create(Mandate::class, ['user_id' => $this->user->id], 3);

        $this->assertEquals(3, $this->user->mandates->count());
    }
}
