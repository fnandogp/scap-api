<?php

namespace Tests\Feature\RemovalRequest;

use App\Enums\RemovalRequestStatus;
use App\Opinion;
use App\RemovalRequest;
use Tests\Feature\FeatureTestCase;

class ManifestAgainstRemovalRequestTest extends FeatureTestCase
{

    /** @test */
    function a_professor_and_a_admin_can_manifest_against_a_removal_request()
    {
        $removal_request = create(RemovalRequest::class, ['type' => 'national', 'status' => 'released']);
        $data            = make(Opinion::class)->toArray();

        $this->post("/removal-requests/{$removal_request->id}/manifest-against", $data,
            $this->getCustomHeader($this->professor))
             ->assertStatus(201)
             ->assertJsonStructure(['message']);

        $this->post("/removal-requests/{$removal_request->id}/manifest-against", $data,
            $this->getCustomHeader($this->admin))
             ->assertStatus(201)
             ->assertJsonStructure(['message']);
    }

    /** @test */
    function a_professor_only_can_manifest_against_a_released_removal_request()
    {
        $status          = array_random(RemovalRequestStatus::keys(['released']));
        $removal_request = create(RemovalRequest::class, ['type' => 'national', 'status' => $status]);
        $data            = make(Opinion::class)->toArray();

        $this->post("/removal-requests/{$removal_request->id}/manifest-against", $data,
            $this->getCustomHeader($this->professor))
             ->assertStatus(403);
    }

    /** @test */
    function a_professor_only_can_manifest_against_a_national_removal_request()
    {
        $removal_request = create(RemovalRequest::class, ['type' => 'international', 'status' => 'released']);
        $data            = make(Opinion::class)->toArray();

        $this->post("/removal-requests/{$removal_request->id}/manifest-against", $data,
            $this->getCustomHeader($this->professor))
             ->assertStatus(403);
    }
}
