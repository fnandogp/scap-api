<?php

namespace App\Enums;

class OpinionType extends BaseEnum
{
    /**
     * RemovalRequestType constructor.
     */
    function __construct()
    {
        $this->collection = collect([
            'positive' => 'Positive',
            'negative' => 'Negative',
        ]);
    }
}
