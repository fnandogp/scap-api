<?php

namespace Tests\Feature\User;

use App\Mandate;
use App\Repositories\MandateRepository;
use App\User;
use Tests\Feature\FeatureTestCase;

class MandateCreateTest extends FeatureTestCase
{
    /** @test */
    function it_create_a_new_mandate()
    {
        $user = create(User::class);
        $data = make(Mandate::class, ['user_id' => $user->id, 'date_to' => null])->toArray();

        $this->post("users/{$user->id}/department-chief", $data, $this->getCustomHeader($this->secretary))
             ->assertJsonStructure(['data', 'message'])
             ->assertStatus(201);
    }

    /** @test */
    function a_professor_can_not_create_a_new_mandate()
    {
        $user = create(User::class);
        $data = make(Mandate::class, ['user_id' => $user->id, 'date_to' => null])->toArray();

        $this->post("users/{$user->id}/department-chief", $data, $this->getCustomHeader($this->admin))
             ->assertStatus(201);

        $this->post("users/{$user->id}/department-chief", $data, $this->getCustomHeader($this->secretary))
             ->assertStatus(201);

        $this->post("users/{$user->id}/department-chief", $data, $this->getCustomHeader($this->professor))
             ->assertStatus(403);
    }
}
