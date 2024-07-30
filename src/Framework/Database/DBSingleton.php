<?php

namespace Framework\Database;
use Framework\Singleton\Singletone;
use mysqli;

class DBSingleton extends Singletone
{
    public static function connect()
    {
        if (is_null(static::$instance)) {

            var_dump(DB_LOCATION);
            static::$instance = new mysqli(DB_LOCATION, DB_USER, DB_PASSWORD, DB_NAME);
        }
        return static::getInstance();
    }
}
