<?php

namespace App\Events;

class OpinionRegistered
{
    
    public $opinion;

    /**
     * Create a new event instance.
     *
     * @param $opinion
     */
    public function __construct($opinion)
    {
        $this->opinion = $opinion;

    }

}
