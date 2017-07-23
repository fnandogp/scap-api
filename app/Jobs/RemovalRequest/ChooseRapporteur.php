<?php

namespace App\Jobs\RemovalRequest;

use App\Repositories\RemovalRequestRepository;

class ChooseRapporteur
{
    /**
     * @var
     */
    private $removal_request_id;
    /**
     * @var
     */
    private $rapporteur_id;

    /**
     * Create a new job instance.
     *
     * @param $removal_request_id
     * @param $rapporteur_id
     */
    public function __construct($removal_request_id, $rapporteur_id)
    {
        $this->removal_request_id = $removal_request_id;
        $this->rapporteur_id      = $rapporteur_id;
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
        $repo->setRapporteur($this->removal_request_id, $this->rapporteur_id);

        $removal_request = $repo->updateStatus($this->removal_request_id, 'released');

        return $removal_request;
    }
}
