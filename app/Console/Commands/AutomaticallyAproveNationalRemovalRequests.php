<?php

namespace App\Console\Commands;

use App\Jobs\RemovalRequest\ApproveNonManifestedNationalRemovalRequest;
use Illuminate\Console\Command;

class AutomaticallyAproveNationalRemovalRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scap:auto-approve-removal-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically approved removal request that nobody manifested against it.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dispatch(new ApproveNonManifestedNationalRemovalRequest);
    }
}
