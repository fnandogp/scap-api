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
        $this->data = $data;
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
        $user                  = \Auth::user();
        $this->data['user_id'] = $user->id;
        $this->data['status']  = RequestStatus::get('initial');

        $request = $repo->create($this->data);

//        event(new RequestCreated($request));

        return $request;
    }
}
