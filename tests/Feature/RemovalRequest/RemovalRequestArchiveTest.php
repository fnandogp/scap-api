<?php

namespace Tests\Feature\RemovalRequest;

use App\RemovalRequest;
use Tests\Feature\FeatureTestCase;

class RemovalRequestArchiveTest extends FeatureTestCase
{
    /** @test */
    function it_archive_a_removal_request()
    {
        $removal_request = create(RemovalRequest::class, [
            'type'   => 'international',
            'status' => 'approved-prppg',
        ]);

        $this->patch("removal-requests/{$removal_request->id}/archive", $this->getCustomHeader($this->admin))
             ->assertJsonStructure(['data', 'message'])
             ->assertStatus(200);

        $removal_request = create(RemovalRequest::class, [
            'type'   => 'international',
            'status' => 'approved-prppg',
        ]);

        $this->patch("removal-requests/{$removal_request->id}/archive", $this->getCustomHeader($this->secretary))
             ->assertJsonStructure(['data', 'message'])
             ->assertStatus(200);
    }


    /** @test */
    function it_archive_only_removal_request_that_is_approved_by_prppg()
    {
        // deny archive started removal request
        $removal_request = create(RemovalRequest::class, [
            'type'   => 'international',
            'status' => 'started',
        ]);

        $this->patch("removal-requests/{$removal_request->id}/archive", $this->getCustomHeader($this->secretary))
             ->assertStatus(403);

        // deny archive approved by di removal request
        $removal_request = create(RemovalRequest::class, [
            'type'   => 'international',
            'status' => 'approved-di',
        ]);

        $this->patch("/removal-requests/{$removal_request->id}/archive")
             ->assertStatus(403);

        // deny archive approved by ct removal request
        $removal_request = create(RemovalRequest::class, [
            'type'   => 'international',
            'status' => 'aprovved-ct',
        ]);

        $this->patch("/removal-requests/{$removal_request->id}/archive")
             ->assertStatus(403);

        // deny archive disapproved removal request
        $removal_request = create(RemovalRequest::class, [
            'type'   => 'international',
            'status' => 'disapproved',
        ]);

        $this->patch("/removal-requests/{$removal_request->id}/archive")
             ->assertStatus(403);
    }
}
