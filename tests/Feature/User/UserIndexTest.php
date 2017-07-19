<?php

namespace Tests\Feature;

use App\User;

class UserIndexTest extends FeatureTestCase
{
    /** @test */
    public function it_index_all_users()
    {
        create(User::class, [], 5);

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
}
