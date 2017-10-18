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
            'canceled'       => 'Canceled',
            'approved-di'    => 'Approved-DI',
            'approved-ct'    => 'Approved-CT',
            'approved-prppg' => 'Approved-PRPPG',
            'archived'       => 'Archived',
            'disapproved'    => 'Disapproved',
        ]);
    }
}