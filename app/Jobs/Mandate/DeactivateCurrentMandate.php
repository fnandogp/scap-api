<?php

namespace App\Jobs\Mandate;

use App\Repositories\MandateRepository;

class DeactivateCurrentMandate
{

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @param MandateRepository $repo
     *
     * @return void
     */
    public function handle(MandateRepository $repo)
    {
        $mandates = $repo->getActives();
        $mandates->each(function ($mandate) {
            $job = new DeactivateMandate($mandate);
            dispatch($job);
        });
    }
}
