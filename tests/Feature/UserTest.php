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
    public function it_fails_to_create_a_user_with_empty_data()
    {
        $this
            ->post("/users", [], $this->getCustomHeader())
            ->assertJson([
                'errors' => [
                    'name'       => [
                        __('validation.required', ['attribute' => 'name'])
                    ],
                    'email'      => [
                        __('validation.required', ['attribute' => 'email'])
                    ],
                    'enrollment' => [
                        __('validation.required', ['attribute' => 'enrollment'])
                    ],
                ]
            ])
            ->assertStatus(422);
    }

    public function it_fails_to_create_a_user_when_input_is_greater_then_permitted_or_non_valid_email()
    {
        $data = [
            'name'       => str_random(256),
            'email'      => str_random(256),
            'enrollment' => str_random(256)
        ];

        $this
            ->post("/users", $data, $this->getCustomHeader())
            ->assertJson([
                'errors' => [
                    'name'       => [
                        __('validation.max.string', ['attribute' => 'name', 'max' => 255])
                    ],
                    'email'      => [
                        __('validation.email', ['attribute' => 'email']),
                        __('validation.max.string', ['attribute' => 'email', 'max' => 255])
                    ],
                    'enrollment' => [
                        __('validation.max.string', ['attribute' => 'enrollment', 'max' => 15])
                    ],
                ]
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function it_fails_to_create_a_user_with_email_already_taken()
    {
        $user = factory(User::class)->create();

        $this
            ->post("/users", $user->toArray(), $this->getCustomHeader())
            ->assertJson([
                'errors' => [
                    'email' => [
                        __('validation.unique', ['attribute' => 'email']),
                    ],
                ]
            ])
            ->assertStatus(422);
    }


    /** @test */
    public function it_edit_a_user()
    {
        $user = factory(User::class)->create();

        $data = [
            'name'       => 'John Doe',
            'email'      => 'john@doe.com',
            'password'   => \Hash::make('secret'),
            'enrollment' => '1234567890'
        ];

        $this
            ->put("/users/{$user->id}", $data, $this->getCustomHeader())
            ->assertJson([
                'data' => [
                    'id'         => $user->id,
                    'name'       => 'John Doe',
                    'email'      => 'john@doe.com',
                    'enrollment' => '1234567890'
                ],
                'meta' => [
                    'message' => __('responses.user.updated'),
                ]
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_fails_to_edit_a_user_with_empty_data()
    {
        $user = factory(User::class)->create();

        $this
            ->put("/users/{$user->id}", [], $this->getCustomHeader())
            ->assertJson([
                'errors' => [
                    'name'       => [
                        __('validation.required', ['attribute' => 'name'])
                    ],
                    'email'      => [
                        __('validation.required', ['attribute' => 'email'])
                    ],
                    'enrollment' => [
                        __('validation.required', ['attribute' => 'enrollment'])
                    ],
                ]
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function it_fails_to_edit_a_user_when_input_is_greater_than_permitted_or_non_valid_email()
    {
        $user = factory(User::class)->create();

        $data = [
            'name'       => str_random(256),
            'email'      => str_random(256),
            'enrollment' => str_random(256)
        ];

        $this
            ->put("/users/{$user->id}", $data, $this->getCustomHeader())
            ->assertJson([
                'errors' => [
                    'name'       => [
                        __('validation.max.string', ['attribute' => 'name', 'max' => 255])
                    ],
                    'email'      => [
                        __('validation.email', ['attribute' => 'email']),
                        __('validation.max.string', ['attribute' => 'email', 'max' => 255])
                    ],
                    'enrollment' => [
                        __('validation.max.string', ['attribute' => 'enrollment', 'max' => 15])
                    ],
                ]
            ])
            ->assertStatus(422);

    }

    /** @test */
    public function it_fails_to_update_user_with_email_already_taken()
    {
        $users = factory(User::class)->times(2)->create();

        $this
            ->put("/users/{$users[0]->id}", $users[1]->toArray(), $this->getCustomHeader())
            ->assertJson([
                'errors' => [
                    'email' => [
                        __('validation.unique', ['attribute' => 'email']),
                    ],
                ]
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function it_index_all_users()
    {
        factory(User::class)->times(5)->create();

        $this
            ->get('/users', [], $this->getCustomHeader())
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'enrollment', 'created_at', 'updated_at']
                ],
            ])
            ->assertStatus(200);
    }
}
