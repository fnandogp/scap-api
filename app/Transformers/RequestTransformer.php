<?php

namespace App\Transformers;

use App\Enums\RequestOnus;
use App\Enums\RequestStatus;
use App\Enums\RequestType;
use App\Request;
use League\Fractal\TransformerAbstract;

class RequestTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Request $request
     *
     * @return array
     * @internal param Request $user
     *
     */
    public function transform(Request $request)
    {
        return [
            'id'                  => (int)$request->id,
            'user_id'             => (int)$request->user->id,
            'type'                => RequestType::get($request->type),
            'status'              => RequestStatus::get($request->status),
            'removal_from'        => $request->removal_from->toDateTimeString(),
            'removal_to'          => $request->removal_to->toDateTimeString(),
            'removal_reason'      => $request->removal_reason,
            'onus'                => RequestOnus::get($request->onus),
            'event'               => $request->event,
            'city'                => $request->city,
            'event_from'          => $request->event_from->toDateTimeString(),
            'event_to'            => $request->event_to->toDateTimeString(),
            'judgment_at'         => $request->judgment_at ? $request->judgment_at->toDateTimeString() : null,
            'canceled_at'         => $request->canceled_at ? $request->canceled_at->toDateTimeString() : null,
            'cancellation_reason' => $request->cancellation_reason,

            'created_at' => $request->created_at->toDateTimeString(),
            'updated_at' => $request->updated_at->toDateTimeString()
        ];
    }
}