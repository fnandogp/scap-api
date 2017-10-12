<?php

namespace Tests\Feature\RemovalRequest;

use App\RemovalRequest;
use Tests\Feature\FeatureTestCase;

class RemovalRequestCreateTest extends FeatureTestCase
{
    /** @test */
    public function it_create_a_removal_request()
    {
        $data = make(RemovalRequest::class, [
            'user_id' => $this->admin->id
        ])->toArray();

        $this->post('/removal-requests', $data, $this->getCustomHeader($this->admin))
             ->assertStatus(201)
             ->assertJsonStructure(['data', 'message']);
    }
}
