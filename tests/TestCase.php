<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations, CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        $this->seed(\InitSeeder::class);
    }
}
