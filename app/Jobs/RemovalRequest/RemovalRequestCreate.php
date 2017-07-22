<?php

namespace App\Jobs\RemovalRequest;

use App\Repositories\RemovalRequestRepository;

class RemovalRequestCreate
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
     * @param RemovalRequestRepository $repo
     *
     * @return mixed
     */
    public function handle(RemovalRequestRepository $repo)
    {
        $this->data['status'] = $this->data['type'] == "national" ? 'released' : 'initial';

        $request = $repo->create($this->data);

//        event(new RequestCreated($request));

        return $request;
    }
}
