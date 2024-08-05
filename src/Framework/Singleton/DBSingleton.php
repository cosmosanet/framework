<?php

namespace Framework\Singleton;

use Framework\Singleton\Singletone;
use mysqli;

class DBSingleton extends Singletone
{
    public static function connect(): mysqli
    {
        if (is_null(static::$instance)) {
            static::$instance = new mysqli(DB_LOCATION, DB_USER, DB_PASSWORD, DB_NAME);
        }
        return static::getInstance();
    }
}
