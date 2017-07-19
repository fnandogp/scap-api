<?php

namespace App\Enums;


class RequestOnus extends BaseEnum
{
    function __construct()
    {
        $this->collection = collect([
            'total' => 'Total',
            'partial' => 'Partial',
            'none' => 'None',
        ]);
    }
}