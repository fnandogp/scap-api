<?php

namespace App\Transformers;

use App\Opinion;
use League\Fractal\TransformerAbstract;

class OpinionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Opinion $opinion
     *
     * @return array
     */
    public function transform(Opinion $opinion)
    {
        return [
            'id'                 => (int)$opinion->id,
            'removal_request_id' => (int)$opinion->removal_request_id,
            'user_id'            => (int)$opinion->user_id,
            'reason'             => $opinion->reason,
            'deferred_at'        => $opinion->created_at->toDateTimeString()
        ];
    }
}
