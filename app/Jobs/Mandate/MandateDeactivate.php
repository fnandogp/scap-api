<?php

namespace App\Jobs\Mandate;

use App\Mandate;
use App\Repositories\MandateRepository;

class MandateDeactivate
{
    /**
     * @var Mandate
     */
    private $mandate;

    /**
     * Create a new job instance.
     *
     * @param Mandate $mandate
     */
    public function __construct(Mandate $mandate)
    {
        $this->mandate = $mandate;
    }

    /**
     * Execute the job.
     *
     * @param MandateRepository $repo
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle(MandateRepository $repo)
    {
        $mandate = $repo->deactivate($this->mandate->id);

        return $mandate;
    }
}
