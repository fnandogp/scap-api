<?php

namespace Tests\Feature;

use App\Enums\RequestStatus;
use App\Enums\RequestType;
use App\Request;
use Carbon\Carbon;

class RequestCreateTest extends FeatureTestCase
{
    /** @test */
    public function it_create_a_removal_request()
    {
        $data = make(Request::class, [
            'user_id' => $this->admin->id
        ])->toArray();

        $this->post('/requests', $data, $this->getCustomHeader($this->admin))
             ->assertStatus(201)
             ->assertJsonStructure(['data', 'message']);
    }
}
