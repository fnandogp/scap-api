<?php

namespace App\Jobs\RemovalRequest;

use App\Repositories\RemovalRequestRepository;

class RemovalRequestArchive
{
    /**
     * @var
     */
    private $removal_request_id;


    /**
     * Create a new job instance.
     *
     * @param $removal_request_id
     */
    public function __construct($removal_request_id)
    {

        $this->removal_request_id = $removal_request_id;
    }


    /**
     * Execute the job.
     *
     * @param \App\Repositories\RemovalRequestRepository $repo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle(RemovalRequestRepository $repo)
    {
        $removal_request = $repo->updateStatus($this->removal_request_id, 'archived');

        return $removal_request;
    }
}
