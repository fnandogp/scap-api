<?php

namespace Tests\Feature;

use App\User;

class UserEditTest extends FeatureTestCase
{


    /** @test */
    public function it_edit_a_user()
    {
        $user = create(User::class);

        $data = [
            'name'       => 'John Doe',
            'email'      => 'john@doe.com',
            'password'   => bcrypt('secret'),
            'enrollment' => '1234567890'
        ];

        $this
            ->put("/users/{$user->id}", $data, $this->getCustomHeader($this->admin))
            ->assertJson([
                'data'    => [
                    'id'         => $user->id,
                    'name'       => 'John Doe',
                    'email'      => 'john@doe.com',
                    'enrollment' => '1234567890'
                ],
                'message' => __('responses.user.updated'),
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_check_permission_of_edit_user()
    {
        $this
            ->put("/users/{$this->admin->id}", $this->admin->toArray(), $this->getCustomHeader($this->admin))
            ->assertStatus(200);

        $this
            ->put("/users/{$this->secretary->id}", $this->secretary->toArray(),
                $this->getCustomHeader($this->secretary))
            ->assertStatus(200);

        $this
            ->put("/users/{$this->professor->id}", $this->professor->toArray(),
                $this->getCustomHeader($this->professor))
            ->assertStatus(403);
    }

    /** @test */
    public function it_fails_to_edit_a_user_with_empty_data()
    {
        $user = create(User::class);

        $this
            ->put("/users/{$user->id}", [], $this->getCustomHeader($this->admin))
            ->assertJson([
                'errors' => [
                    'name'       => [__('validation.required', ['attribute' => 'name'])],
                    'email'      => [__('validation.required', ['attribute' => 'email'])],
                    'enrollment' => [__('validation.required', ['attribute' => 'enrollment'])],
                ]
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function it_fails_to_edit_a_user_when_input_is_greater_than_permitted_or_non_valid_email()
    {
        $user = create(User::class);

        $data = [
            'name'       => str_random(256),
            'email'      => str_random(256),
            'enrollment' => str_random(256)
        ];

        $this
            ->put("/users/{$user->id}", $data, $this->getCustomHeader($this->admin))
            ->assertJson([
                'errors' => [
                    'name'       => [__('validation.max.string', ['attribute' => 'name', 'max' => 255])],
                    'email'      => [
                        __('validation.email', ['attribute' => 'email']),
                        __('validation.max.string', ['attribute' => 'email', 'max' => 255])
                    ],
                    'enrollment' => [__('validation.max.string', ['attribute' => 'enrollment', 'max' => 15])],
                ]
            ])
            ->assertStatus(422);

    }

    /** @test */
    public function it_fails_to_update_user_with_email_already_taken()
    {
        $user1 = create(User::class);
        $user2 = create(User::class);

        $this
            ->put("/users/{$user1->id}", $user2->toArray(), $this->getCustomHeader($this->admin))
            ->assertJson([
                'errors' => [
                    'email' => [__('validation.unique', ['attribute' => 'email'])],
                ]
            ])
            ->assertStatus(422);
    }
}