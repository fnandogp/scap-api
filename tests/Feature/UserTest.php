<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_create_a_new_user()
    {
        $data = [
            'name'       => 'John Doe',
            'email'      => 'john@doe.com',
            'password'   => \Hash::make('secret'),
            'enrollment' => '1234567890'
        ];

        $this->post('/users', $data, $this->getCustomHeader())
             ->assertJson([
                 'data' => [
                     'name'       => 'John Doe',
                     'email'      => 'john@doe.com',
                     'enrollment' => '1234567890'
                 ],
                 'meta' => [
                     'message' => __('responses.user.created'),
                 ]
             ])
             ->assertStatus(200);
    }

    /** @test */
    public function it_fails_to_create_an_user()
    {
        $user = factory(User::class)->create();

        $this->post('/users', $user->toArray(), $this->getCustomHeader())
             ->assertStatus(422);
    }

}
