<?php

namespace Framework\Singleton;

class Singletone
{
    protected static $instance;

    protected function __construct()
    {
    }
    protected function __clone()
    {
    }
    protected static function getInstance()
    {
        return static::$instance;
    }
}
