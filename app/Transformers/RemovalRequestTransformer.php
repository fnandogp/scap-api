<?php

namespace App\Transformers;

use App\Enums\RemovalRequestOnus;
use App\Enums\RemovalRequestStatus;
use App\Enums\RemovalRequestType;
use App\RemovalRequest;
use League\Fractal\TransformerAbstract;

class RemovalRequestTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param RemovalRequest $removal_request
     *
     * @return array
     * @internal param RemovalRequest $user
     *
     */
    public function transform(RemovalRequest $removal_request)
    {
        return [
            'id'                  => (int)$removal_request->id,
            'user_id'             => (int)$removal_request->user->id,
            'type'                => RemovalRequestType::get($removal_request->type),
            'status'              => RemovalRequestStatus::get($removal_request->status),
            'removal_from'        => $removal_request->removal_from->toDateTimeString(),
            'removal_to'          => $removal_request->removal_to->toDateTimeString(),
            'removal_reason'      => $removal_request->removal_reason,
            'onus'                => RemovalRequestOnus::get($removal_request->onus),
            'event'               => $removal_request->event,
            'city'                => $removal_request->city,
            'event_from'          => $removal_request->event_from->toDateTimeString(),
            'event_to'            => $removal_request->event_to->toDateTimeString(),
            'judgment_at'         => $removal_request->judgment_at ? $removal_request->judgment_at->toDateTimeString() : null,
            'canceled_at'         => $removal_request->canceled_at ? $removal_request->canceled_at->toDateTimeString() : null,
            'cancellation_reason' => $removal_request->cancellation_reason,

            'created_at' => $removal_request->created_at->toDateTimeString(),
            'updated_at' => $removal_request->updated_at->toDateTimeString()
        ];
    }
}