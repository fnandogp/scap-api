<?php

namespace Tests\Feature\Opinion;

use App\Opinion;
use App\RemovalRequest;
use Tests\Feature\FeatureTestCase;

class RegisterPrppgOpinionTest extends FeatureTestCase
{
    /**
     * @var
     */
    private $removal_request;

    protected function setUp()
    {
        parent::setUp();

        $this->removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'approved-ct']);
    }

    /** @test */
    function it_register_the_opinion_for_prppg()
    {
        $data = make(Opinion::class)->toArray();

        $this->post("removal-requests/{$this->removal_request->id}/register-prppg-opinion", $data,
            $this->getCustomHeader($this->secretary))
             ->assertStatus(201)
             ->assertJsonStructure(['data', 'message']);
    }

    /** @test */
    function a_secretary_and_a_admin_can_register_the_opinion_for_prppg()
    {
        $data            = make(Opinion::class)->toArray();
        $removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'approved-ct']);
        $this->post("removal-requests/{$removal_request->id}/register-prppg-opinion", $data,
            $this->getCustomHeader($this->secretary))
             ->assertStatus(201)
             ->assertJsonStructure(['data', 'message']);

        $removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'approved-ct']);
        $this->post("removal-requests/{$removal_request->id}/register-prppg-opinion", $data,
            $this->getCustomHeader($this->admin))
             ->assertStatus(201)
             ->assertJsonStructure(['data', 'message']);
    }

    /** @test */
    function a_professor_can_not_register_the_opinion_for_prppg()
    {
        $data = make(Opinion::class)->toArray();

        $this->post("removal-requests/{$this->removal_request->id}/register-prppg-opinion", $data,
            $this->getCustomHeader($this->professor))
             ->assertStatus(403);
    }
}
