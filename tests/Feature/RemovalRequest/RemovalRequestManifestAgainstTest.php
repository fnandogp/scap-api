<?php

namespace Tests\Feature\Request;

use App\Opinion;
use App\RemovalRequest;
use Tests\Feature\FeatureTestCase;

class RemovalRequestManifestAgainstTest extends FeatureTestCase
{
    private $removal_request;

    protected function setUp()
    {
        parent::setUp();

        $this->removal_request = create(RemovalRequest::class);
    }

    /** @test */
    function a_professor_can_manifest_against_a_removal_request()
    {
        $data = make(Opinion::class)->toArray();

        $this->post("/removal-requests/{$this->removal_request->id}/manifest-against", $data,
            $this->getCustomHeader($this->admin))
             ->assertStatus(201)
             ->assertJsonStructure(['message']);
    }
}
