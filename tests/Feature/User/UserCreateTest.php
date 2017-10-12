<?php

namespace Tests\Feature\User;

use App\User;
use Tests\Feature\FeatureTestCase;

class UserCreateTest extends FeatureTestCase
{
    /** @test */
    public function it_create_a_new_user()
    {
        $data = [
            'name'       => 'John Doe',
            'email'      => 'john@doe.com',
            'password'   => bcrypt('secret'),
            'enrollment' => '1234567890',
            'roles'      => ['admin'],
        ];

        $this
            ->post('/users', $data, $this->getCustomHeader($this->admin))
            ->assertJson([
                'data'    => [
                    'name'       => 'John Doe',
                    'email'      => 'john@doe.com',
                    'enrollment' => '1234567890',
                    'roles'      => ['admin'],
                ],
                'message' => __('responses.user.created'),
            ])
            ->assertStatus(201);
    }


    /** @test */
    public function it_check_permission_of_create_user()
    {
        $data = [
            'name'       => 'John Doe',
            'email'      => 'john@doe.com',
            'password'   => bcrypt('secret'),
            'enrollment' => '1234567890',
            'roles'      => ['admin'],
        ];

        $this
            ->post('/users', $data, $this->getCustomHeader($this->admin))
            ->assertStatus(201);

        $data['email'] .= '.com';
        $this
            ->post('/users', $data, $this->getCustomHeader($this->secretary))
            ->assertStatus(201);

        $data['email'] .= '.com';
        $this
            ->post('/users', $data, $this->getCustomHeader($this->professor))
            ->assertStatus(403);
    }


    public function it_fails_to_create_a_user_when_input_is_greater_then_permitted_or_non_valid_email()
    {
        $data = [
            'name'       => str_random(256),
            'email'      => str_random(256),
            'enrollment' => str_random(256),
        ];

        $this
            ->post("/users", $data, $this->getCustomHeader($this->admin))
            ->assertJson([
                'errors' => [
                    'name'       => [
                        __('validation.max.string', ['attribute' => 'name', 'max' => 255]),
                    ],
                    'email'      => [
                        __('validation.email', ['attribute' => 'email']),
                        __('validation.max.string', ['attribute' => 'email', 'max' => 255]),
                    ],
                    'enrollment' => [
                        __('validation.max.string', ['attribute' => 'enrollment', 'max' => 15]),
                    ],
                ],
            ])
            ->assertStatus(422);
    }


    /** @test */
    public function it_fails_to_create_a_user_with_email_already_taken()
    {
        $user = create(User::class);

        $this
            ->post("/users", $user->toArray(), $this->getCustomHeader($this->admin))
            ->assertJson([
                'errors' => [
                    'email' => [
                        __('validation.unique', ['attribute' => 'email']),
                    ],
                ],
            ])
            ->assertStatus(422);
    }


    /** @test */
    function it_fails_to_create_on_missing_field()
    {
        $this
            ->post("/users", [], $this->getCustomHeader($this->admin))
            ->assertJsonStructure([
                'errors' => [
                    'name',
                    'email',
                    'enrollment',
                    'password',
                    'roles',
                ],
            ])
            ->assertStatus(422);
    }
}