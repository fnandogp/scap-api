<?php

namespace Tests\Feature\User;

use App\User;
use Tests\Feature\FeatureTestCase;

class UserDeleteTest extends FeatureTestCase
{
    /** @test */
    public function it_deletes_a_user()
    {
        $user = create(User::class);

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
