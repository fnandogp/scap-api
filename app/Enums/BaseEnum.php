<?php

namespace App\Enums;

abstract class BaseEnum
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $collection;

    /**
     * Get all key and values
     *
     * @return array
     */
    public static function all()
    {
        return (new static)->collection->all();
    }

    /**
     * Get a single value by key
     *
     * @param $key
     *
     * @return string
     */
    public static function get($key)
    {
        return (new static)->collection->get($key);
    }

    /**
     * Get only the keys
     *
     * @return array
     */
    public static function keys()
    {
        return (new static)->collection->keys()->all();
    }

    /**
     * Get only the values
     *
     * @return array
     */
    public static function values()
    {
        return (new static)->collection->values()->all();
    }

    /**
     * Get  only the keys separated by comma
     *
     * @return string
     */
    public static function implode()
    {
        return (new static)->collection->keys()->implode(',');
    }
}