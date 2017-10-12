<?php

namespace App\Jobs\Opinion;

use App\Events\OpinionRegistered;
use App\Repositories\OpinionRepository;

class RegisterOpinion
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
        $data       = array_only($data, ['removal_request_id', 'user_id', 'registered_for', 'type', 'reason']);
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param OpinionRepository $repo
     *
     * @return mixed
     */
    public function handle(OpinionRepository $repo)
    {
        $opinion = $repo->create($this->data);

        event(new OpinionRegistered($opinion));

        return $opinion;
    }
}
