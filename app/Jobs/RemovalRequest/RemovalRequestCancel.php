<?php

namespace App\Jobs\RemovalRequest;

use App\Repositories\RemovalRequestRepository;

class RemovalRequestCancel
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
        $data = array_only($data, ['removal_request_id', 'cancellation_reason']);

        $this->data = $data;
    }


    /**
     * Execute the job.
     *
     * @param \App\Repositories\RemovalRequestRepository $repo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle(RemovalRequestRepository $repo)
    {
        $removal_request = $repo->cancel($this->data['removal_request_id'], $this->data['cancellation_reason']);

        return $removal_request;
    }
}
