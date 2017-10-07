<?php

namespace Tests\Feature\RemovalRequest;

use App\RemovalRequest;
use Tests\Feature\FeatureTestCase;

class RemovalRequestShowTest extends FeatureTestCase
{
    /** @test */
    public function it_show_a_removal_request()
    {
        $removal_request = create(RemovalRequest::class);

        $this
            ->get("/removal-requests/{$removal_request->id}", [], $this->getCustomHeader($this->admin))
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user',
                    'type',
                    'status',
                    'removal_from',
                    'removal_to',
                    'removal_reason',
                    'onus',
                    'event',
                    'city',
                    'event_from',
                    'event_to',
                    'judgment_at',
                    'canceled_at',
                    'cancellation_reason',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertStatus(200);
    }
}
