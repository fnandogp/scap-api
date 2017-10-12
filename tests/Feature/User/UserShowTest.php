<?php

namespace Tests\Feature\User;

use App\User;
use Tests\Feature\FeatureTestCase;

class UserShowTest extends FeatureTestCase
{

    /** @test */
    public function it_show_a_single_user()
    {
        $user = create(User::class);

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
}