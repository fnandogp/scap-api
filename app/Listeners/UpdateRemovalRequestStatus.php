<?php

namespace App\Listeners;

use App\Events\OpinionOfCtRegistered;
use App\Events\OpinionRegistered;
use App\Repositories\RemovalRequestRepository;

class UpdateRemovalRequestStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param OpinionRegistered $event
     */
    public function handle(OpinionRegistered $event)
    {
        $repo = new RemovalRequestRepository;

        if ($event->opinion->registered_for == 'ct') {
            $status = $event->opinion->type == 'positive' ? 'approved-ct' : 'disapproved';
        } else {
            $status = $event->opinion->type == 'positive' ? 'approved-prppg' : 'disapproved';
        }

        $repo->updateStatus($event->opinion->removal_request_id, $status);
    }
}
