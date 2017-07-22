<?php

namespace Tests\Unit;

use App\Opinion;
use App\RemovalRequest;
use App\User;
use Tests\TestCase;

class OpinionTest extends TestCase
{
    private $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = create(User::class);
    }

    /** @test */
    function an_opinion_belongs_to_a_user()
    {
        $user    = create(User::class);
        $opinion = create(Opinion::class, ['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $opinion->user);
    }

    /** @test */
    function an_opinion_belongs_to_a_removal_request()
    {
        $removal_request = create(RemovalRequest::class);
        $opinion         = create(Opinion::class, ['removal_request_id' => $removal_request->id]);

        $this->assertInstanceOf(RemovalRequest::class, $opinion->removalRequest);
    }

}
