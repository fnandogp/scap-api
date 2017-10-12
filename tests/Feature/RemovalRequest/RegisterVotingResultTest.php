<?php

namespace Tests\Feature\RemovalRequest;

use App\RemovalRequest;
use Tests\Feature\FeatureTestCase;

class RegisterVotingResultTest extends FeatureTestCase
{

    private $removal_request;

    protected function setUp()
    {
        parent::setUp();

        $this->removal_request = create(RemovalRequest::class, ['type' => 'national', 'status' => 'released']);
    }

    /** @test */
    function it_register_a_positive_voting_result_for_removal_requests()
    {
        $data = [
            'type' => 'positive'
        ];

        $this->patch("/removal-requests/{$this->removal_request->id}/register-voting-result", $data,
            $this->getCustomHeader($this->admin))
             ->assertStatus(200)
             ->assertJsonStructure(['message']);
    }

    /** @test */
    function it_register_a_negative_voting_result_for_removal_requests()
    {
        $data = [
            'type' => 'negative'
        ];

        $this->patch("/removal-requests/{$this->removal_request->id}/register-voting-result", $data,
            $this->getCustomHeader($this->admin))
             ->assertStatus(200)
             ->assertJsonStructure(['message']);
    }

    /** @test */
    function a_secretary_can_register_a_voting_result_for_removal_requests()
    {
        $data = [
            'type' => 'positive'
        ];

        $this->patch("/removal-requests/{$this->removal_request->id}/register-voting-result", $data,
            $this->getCustomHeader($this->secretary))
             ->assertStatus(200)
             ->assertJsonStructure(['message']);
    }

    /** @test */
    function a_professor_can_not_register_voting_result_for_removal_requests()
    {
        $data = [
            'type' => 'positive'
        ];

        $this->patch("/removal-requests/{$this->removal_request->id}/register-voting-result", $data,
            $this->getCustomHeader($this->professor))
             ->assertStatus(403);
    }
}
