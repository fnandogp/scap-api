<?php

namespace Tests\Feature\RemovalRequest;

use App\RemovalRequest;
use Tests\Feature\FeatureTestCase;

class RemovalRequestIndexTest extends FeatureTestCase
{
    /** @test */
    public function it_index_removal_requests()
    {
        create(RemovalRequest::class, [], 5);

        $this
            ->get('/removal-requests', [], $this->getCustomHeader($this->admin))
            ->assertJsonStructure([
                'data' => [
                    '*' => [
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
                ],
            ])
            ->assertStatus(200);
    }


    /** @test */
    function it_index_all_removal_request_created_by_the_current_user()
    {
        create(RemovalRequest::class, [], 2);

        create(RemovalRequest::class, [
            'user_id' => $this->admin->id,
        ]);

        $response = $this
            ->get('/me/removal-requests', [], $this->getCustomHeader($this->admin))
            ->assertStatus(200)
            ->decodeResponseJson();

        $this->assertCount(1, $response['data']);
    }
}

