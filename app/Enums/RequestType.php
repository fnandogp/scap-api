<?php

namespace App\Enums;

class RequestType extends BaseEnum
{
    /**
     * RequestType constructor.
     */
    function __construct()
    {
        $this->collection = collect([
            'national'      => 'National',
            'international' => 'International',
        ]);
    }
}
