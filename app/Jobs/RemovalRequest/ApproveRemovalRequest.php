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
     * @return void
     */
    public function handle(RemovalRequestRepository $repo)
    {
        $repo->approve($this->id, $this->status);
    }
}
