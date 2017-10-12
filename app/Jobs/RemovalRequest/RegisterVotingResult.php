<?php

namespace App\Jobs\RemovalRequest;

use App\Repositories\RemovalRequestRepository;

class RegisterVotingResult
{

    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $data = array_only($data, ['removal_request_id', 'type']);

        $this->data = $data;
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
        if ($this->data['type'] == 'positive') {
            return $repo->updateStatus($this->data['removal_request_id'], 'approved-di');
        }

        return $repo->updateStatus($this->data['removal_request_id'], 'disapproved');
    }
}
