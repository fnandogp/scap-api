<?php

namespace App\Transformers;

use App\Mandate;
use League\Fractal\TransformerAbstract;

class MandateTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Mandate $mandate
     *
     * @return array
     */
    public function transform(Mandate $mandate)
    {
        return [
            'user_id'   => (int)$mandate->user->id,
            'date_from' => $mandate->date_from,
            'date_to'   => $mandate->date_to
        ];
    }
}
