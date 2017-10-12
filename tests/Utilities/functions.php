<?php
/**
 * Use the factory to create a instance of a given class
 *
 * @param $class
 * @param array $attributes
 * @param int $times
 *
 * @return mixed
 */
function create($class, $attributes = [], $times = 1)
{
    if ($times > 1) {
        return factory($class, $times)->create($attributes);
    }

    return factory($class)->create($attributes);
}

/**
 * Use the factory to make a instance of a given class
 *
 * @param $class
 * @param array $attributes
 * @param int $times
 *
 * @return mixed
 */
function make($class, $attributes = [], $times = 1)
{
    if ($times > 1) {
        return factory($class, $times)->make($attributes);
    }

    return factory($class)->make($attributes);
}