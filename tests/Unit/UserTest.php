<?php

namespace Tests\Unit;

use App\Request;
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
    function a_user_can_make_requests()
    {
        // @TODO: implement the relation test
//        $request = create(Request::class, ['user_id' => $this->user->id]);
//
//        $this->assertEquals($request->id, $this->user->requests->first->id);
    }
}
