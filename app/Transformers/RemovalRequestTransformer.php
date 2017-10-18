<?php

namespace App\Transformers;

use App\Enums\RemovalRequestOnus;
use App\Enums\RemovalRequestStatus;
use App\Enums\RemovalRequestType;
use App\RemovalRequest;
use League\Fractal\Scope;
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
            'id'                  => (int) $removal_request->id,
            'type'                => RemovalRequestType::get($removal_request->type),
            'status'              => RemovalRequestStatus::get($removal_request->status),
            'removal_from'        => $removal_request->removal_from,
            'removal_to'          => $removal_request->removal_to,
            'removal_reason'      => $removal_request->removal_reason,
            'onus'                => RemovalRequestOnus::get($removal_request->onus),
            'event'               => $removal_request->event,
            'city'                => $removal_request->city,
            'event_from'          => $removal_request->event_from,
            'event_to'            => $removal_request->event_to,
            'judgment_at'         => $removal_request->judgment_at ? $removal_request->judgment_at->toDateTimeString() : null,
            'canceled_at'         => $removal_request->canceled_at ? $removal_request->canceled_at->toDateTimeString() : null,
            'cancellation_reason' => $removal_request->cancellation_reason,

            'user'       => $this->getUser($removal_request),
            'rapporteur' => $this->getRapporteur($removal_request),

            'created_at' => $removal_request->created_at->toDateTimeString(),
            'updated_at' => $removal_request->updated_at->toDateTimeString(),
        ];
    }


    /**
     * @param \App\RemovalRequest $removal_request
     * @return array
     */
    private function getUser(RemovalRequest $removal_request)
    {
        $user_transformer = new UserTransformer;

        return $removal_request->user ? $user_transformer->transform($removal_request->user) : null;
    }


    /**
     * @param \App\RemovalRequest $removal_request
     * @return array
     */
    private function getRapporteur(RemovalRequest $removal_request)
    {
        $user_transformer = new UserTransformer;

        return $removal_request->rapporteur ? $user_transformer->transform($removal_request->rapporteur) : null;
    }
}