<?php

namespace App\Jobs\Opinion;

use App\Repositories\OpinionRepository;

class ManifestAgainstRemovalRequest
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
            'removal_request_id',
            'user_id',
            'reason'
        ]);

        $this->data['type'] = 'negative';
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

        return $opinion;
    }
}
