<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param array $headers
     *
     * @return array
     */
    public function getCustomHeader($headers = [])
    {
        return array_merge(['X-Requested-With' => 'XMLHttpRequest'], $headers);
    }
}
