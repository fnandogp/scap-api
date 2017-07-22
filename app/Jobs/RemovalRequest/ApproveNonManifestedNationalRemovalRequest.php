<?php

namespace App\Jobs\RemovalRequest;

use App\Repositories\RemovalRequestRepository;

class ApproveNonManifestedNationalRemovalRequest
{
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @param RemovalRequestRepository $repo
     *
     * @return void
     */
    public function handle(RemovalRequestRepository $repo)
    {
        $removal_requests = $repo->getNonManifestedNationalReleased();

        $removal_requests->each(function ($removal_request) {
            dispatch(new ApproveRemovalRequest($removal_request->id, 'approved-di'));
        });
    }
}
