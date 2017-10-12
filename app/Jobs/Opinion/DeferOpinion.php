<?php

namespace App\Jobs\Opinion;

use App\Repositories\OpinionRepository;
use App\Repositories\RemovalRequestRepository;

class DeferOpinion

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
        $data       = array_only($data, ['removal_request_id', 'user_id', 'type', 'reason']);
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param OpinionRepository $repo_opinion
     * @param RemovalRequestRepository $repo_removal_request
     *
     * @return mixed
     */
    public function handle(OpinionRepository $repo_opinion, RemovalRequestRepository $repo_removal_request)
    {
        $opinion = $repo_opinion->create($this->data);

        $status = $opinion->type == 'positive' ? 'approved-di' : 'disapproved';
        $repo_removal_request->updateStatus($opinion->removal_request_id, $status);

        return $opinion;
    }
}
