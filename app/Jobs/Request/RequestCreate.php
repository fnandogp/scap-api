<?php

namespace App\Jobs\Request;

use App\Enums\RequestStatus;
use App\Repositories\RequestRepository;

class RequestCreate
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
        $this->data = array_only($data, [
            'user_id',
            'type',
            'removal_from',
            'removal_to',
            'removal_reason',
            'event',
            'city',
            'event_from',
            'event_to',
            'onus'
        ]);
    }

    /**
     * Execute the job.
     *
     * @param RequestRepository $repo
     *
     * @return mixed
     */
    public function handle(RequestRepository $repo)
    {
        $this->data['status'] = $this->data['type'] == "national" ? 'released' : 'initial';

        $request = $repo->create($this->data);

//        event(new RequestCreated($request));

        return $request;
    }
}
