<?php

namespace App\Jobs\RemovalRequest;

use App\Repositories\RemovalRequestRepository;

class ApproveRemovalRequest
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $status;

    /**
     * Create a new job instance.
     *
     * @param int $id
     * @param $status
     */
    public function __construct($id, $status)
    {
        $this->id     = $id;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @param RemovalRequestRepository $repo
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle(RemovalRequestRepository $repo)
    {
        $removal_request = $repo->updateStatus($this->id, $this->status);

        return $removal_request;
    }
}
