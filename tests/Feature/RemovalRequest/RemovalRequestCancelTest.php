<?php

namespace Tests\Feature\RemovalRequest;

use App\RemovalRequest;
use App\User;
use Tests\Feature\FeatureTestCase;

class RemovalRequestCancelTest extends FeatureTestCase
{
    /** @test */
    function it_cancel_a_removal_request()
    {
        $removal_request = create(RemovalRequest::class, [
            'user_id' => $this->professor->id,
            'status'  => 'started',
        ]);

        $data = ['cancellation_reason' => $removal_request->cancellation_reason];

        $this->patch("removal-requests/{$removal_request->id}/cancel", $data, $this->getCustomHeader($this->professor))
             ->assertJsonStructure(['data', 'message'])
             ->assertStatus(200);
    }


    /** @test */
    function it_deny_a_user_cancel_a_removal_request_that_was_not_created_by_him()
    {
        $user = create(User::class);
        $removal_request = create(RemovalRequest::class, [
            'user_id' => $user->id,
            'status'  => 'started',
        ]);

        $data = ['cancellation_reason' => $removal_request->cancellation_reason];

        $this->patch("removal-requests/{$removal_request->id}/cancel", $data, $this->getCustomHeader($this->professor))
             ->assertStatus(403);
    }


    /** @test */
    function it_deny_a_user_cancel_a_removal_request_that_is_archive_or_disapproved_or_cancelled()
    {
        $removal_request = create(RemovalRequest::class, [
            'user_id' => $this->professor->id,
            'status'  => 'archived',
        ]);
        $data = ['cancellation_reason' => $removal_request->cancellation_reason];
        $this->patch("removal-requests/{$removal_request->id}/cancel", $data, $this->getCustomHeader($this->professor))
             ->assertStatus(403);

        $removal_request = create(RemovalRequest::class, [
            'user_id' => $this->professor->id,
            'status'  => 'disapproved',
        ]);
        $data = ['cancellation_reason' => $removal_request->cancellation_reason];
        $this->patch("removal-requests/{$removal_request->id}/cancel", $data, $this->getCustomHeader($this->professor))
             ->assertStatus(403);

        $removal_request = create(RemovalRequest::class, [
            'user_id' => $this->professor->id,
            'status'  => 'cancelled',
        ]);
        $data = ['cancellation_reason' => $removal_request->cancellation_reason];
        $this->patch("removal-requests/{$removal_request->id}/cancel", $data, $this->getCustomHeader($this->professor))
             ->assertStatus(403);
    }
}
