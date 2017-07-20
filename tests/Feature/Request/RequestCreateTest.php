<?php

namespace Tests\Feature;

use App\Enums\RequestStatus;
use App\Enums\RequestType;
use App\Request;
use Carbon\Carbon;

class RequestCreateTest extends FeatureTestCase
{
    /** @test */
    public function it_create_a_national_removal_request()
    {
        $data = make(Request::class, [
            'user_id' => $this->admin->id,
            'type'    => RequestType::get('national')
        ])->toArray();

        $this->post('/requests', $data, $this->getCustomHeader($this->admin))
             ->assertJsonStructure(['data', 'message'])
             ->assertStatus(201);
    }

    /** @test */
    public function it_create_a_international_removal_request()
    {
        $data = make(Request::class, [
            'user_id' => $this->admin->id,
            'type'    => RequestType::get('international')
        ])->toArray();

        $this->post('/requests', $data, $this->getCustomHeader($this->admin))
             ->assertJsonStructure(['data', 'message'])
             ->assertStatus(201);
    }
}
