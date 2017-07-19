<?php

namespace App\Repositories;

use App\Request;

class RequestRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected $model_class = Request::class;
}