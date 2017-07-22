<?php

namespace App\Jobs\Mandate;

use App\Mandate;
use App\Repositories\MandateRepository;

class CreateMandate
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
     * @param MandateRepository $repo
     *
     * @return Mandate
     */
    public function handle(MandateRepository $repo)
    {
        // First deactivate all current activated mandates
        $job = new DeactivateCurrentMandate();
        dispatch($job);

        $mandate = $repo->create($this->data);

        return $mandate;
    }
}
