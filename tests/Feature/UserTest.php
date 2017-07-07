<?php

namespace Tests\Feature;

use App\User;

class UserTest extends FeatureTestCase
{

    /** @test */
    public function it_create_a_new_user()
    {
        $data = [
            'name'       => 'John Doe',
            'email'      => 'john@doe.com',
            'password'   => bcrypt('secret'),
            'enrollment' => '1234567890'
        ];

        $this
            ->post('/users', $data, $this->getCustomHeader($this->admin))
            ->assertJson([
                'data'    => [
                    'name'       => 'John Doe',
                    'email'      => 'john@doe.com',
                    'enrollment' => '1234567890'
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
            'enrollment' => '1234567890'
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

    /** @test */
    public function it_fails_to_create_a_user_with_empty_data()
    {
        $this
            ->post("/users", [], $this->getCustomHeader($this->admin))
            ->assertJson([
                'errors' => [
                    'name'       => [__('validation.required', ['attribute' => 'name'])],
                    'email'      => [__('validation.required', ['attribute' => 'email'])],
                    'enrollment' => [__('validation.required', ['attribute' => 'enrollment'])],
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
            ->post("/users", $data, $this->getCustomHeader($this->admin))
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
            ->post("/users", $user->toArray(), $this->getCustomHeader($this->admin))
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
        $user = factory(User::class)->create();

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
        $user = factory(User::class)->create();

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
        $users = factory(User::class)->times(2)->create();

        $this
            ->put("/users/{$users[0]->id}", $users[1]->toArray(), $this->getCustomHeader($this->admin))
            ->assertJson([
                'errors' => [
                    'email' => [__('validation.unique', ['attribute' => 'email'])],
                ]
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function it_index_all_users()
    {
        factory(User::class)->times(5)->create();

        $this
            ->get('/users', [], $this->getCustomHeader($this->admin))
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'enrollment', 'created_at', 'updated_at']
                ],
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_check_permission_to_index_user()
    {
        $this
            ->get("/users", [], $this->getCustomHeader($this->admin))
            ->assertStatus(200);

        $this
            ->get("/users", [], $this->getCustomHeader($this->secretary))
            ->assertStatus(200);

        $this
            ->get("/users", [], $this->getCustomHeader($this->professor))
            ->assertStatus(403);
    }

    /** @test */
    public function it_show_a_single_user()
    {
        $user = factory(User::class)->create();

        $this
            ->get("/users/{$user->id}", [], $this->getCustomHeader($this->admin))
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'enrollment', 'created_at', 'updated_at']
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_check_permission_of_show_user()
    {
        $this
            ->get("/users/{$this->admin->id}", [], $this->getCustomHeader($this->admin))
            ->assertStatus(200);

        $this
            ->get("/users/{$this->secretary->id}", [], $this->getCustomHeader($this->secretary))
            ->assertStatus(200);

        $this
            ->get("/users/{$this->professor->id}", [], $this->getCustomHeader($this->professor))
            ->assertStatus(403);
    }

    /** @test */
    public function it_deletes_a_user()
    {
        $user = factory(User::class)->create();

        $this
            ->delete("/users/{$user->id}", [], $this->getCustomHeader($this->admin))
            ->assertJson([
                'message' => __('responses.user.deleted')
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_check_permission_of_delete_user()
    {
        $this
            ->delete("/users/{$this->admin->id}", [], $this->getCustomHeader($this->admin))
            ->assertStatus(200);

        $this
            ->delete("/users/{$this->secretary->id}", [], $this->getCustomHeader($this->secretary))
            ->assertStatus(200);

        $this
            ->delete("/users/{$this->professor->id}", [], $this->getCustomHeader($this->professor))
            ->assertStatus(403);
    }
}
