<?php

namespace App\Enums;

class RemovalRequestType extends BaseEnum
{
    /**
     * RemovalRequestType constructor.
     */
    function __construct()
    {
        $this->collection = collect([
            'national'      => 'National',
            'international' => 'International',
        ]);
    }
}
