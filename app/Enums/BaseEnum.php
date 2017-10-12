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
     * @param array $exclude
     *
     * @return array
     */
    public static function all($exclude = [])
    {
        return (new static)->collection
            ->except($exclude)
            ->all();
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
     * @param array $exclude
     *
     * @return array
     */
    public static function keys($exclude = [])
    {
        return (new static)->collection
            ->keys()
            ->except($exclude)
            ->all();
    }

    /**
     * Get only the values
     *
     * @param array $exclude
     *
     * @return array
     */
    public static function values($exclude = [])
    {
        return (new static)->collection
            ->values()
            ->except($exclude)
            ->all();
    }

    /**
     * Get  only the keys separated by comma
     *
     * @return string
     */
    public static function implode()
    {
        return (new static)->collection
            ->keys()
            ->implode(',');
    }
}