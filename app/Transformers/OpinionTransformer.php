<?php

namespace App\Transformers;

use App\Opinion;
use League\Fractal\TransformerAbstract;

class OpinionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['removal_request'];


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
            'id'          => (int) $opinion->id,
            'user_id'     => (int) $opinion->user_id,
            'reason'      => $opinion->reason,
            'deferred_at' => $opinion->created_at->toDateTimeString(),
        ];
    }


    public function includeRemovalRequest(Opinion $opinion)
    {
        return $this->item($opinion->removalRequest, new RemovalRequestTransformer);
    }
}
