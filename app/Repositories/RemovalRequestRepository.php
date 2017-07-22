<?php

namespace App\Repositories;

use App\RemovalRequest;

class RemovalRequestRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected $model_class = RemovalRequest::class;
}