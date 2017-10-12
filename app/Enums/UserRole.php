<?php

namespace App\Enums;

class UserRole extends BaseEnum
{
    /**
     * RemovalRequestType constructor.
     */
    function __construct()
    {
        $this->collection = collect([
            'admin'     => 'Administrator',
            'professor' => 'Professor',
            'secretary' => 'Secretary',
        ]);
    }
}
