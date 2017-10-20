<?php

namespace App\Enums;

class RemovalRequestStatus extends BaseEnum
{
    function __construct()
    {
        $this->collection = collect([
            'started'        => 'Started',
            'released'       => 'Released',
            'blocked'        => 'Blocked',
            'appropriate'    => 'Appropriate',
            'cancelled'      => 'Cancelled',
            'approved-di'    => 'Approved-DI',
            'approved-ct'    => 'Approved-CT',
            'approved-prppg' => 'Approved-PRPPG',
            'archived'       => 'Archived',
            'disapproved'    => 'Disapproved',
        ]);
    }
}