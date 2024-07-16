<?php

namespace Framework\Facade;

use Exception;

class Facade
{
    protected static $instance;
    protected static function getFacadeAccessor()
    {
        throw new Exception('Facade does not implement getFacadeAccessor method.');
    }
    protected static function createInstance(): object
    {
        $class = static::getFacadeAccessor();
        if (!class_exists($class)) {
            throw new Exception('The facade of the class does not exist.');
        }
        static::$instance = new $class;
        return static::$instance;
    }
    public static function __callStatic($method, $args)
    {
        $class = static::createInstance();
        if (!method_exists($class, $method)) {
            throw new Exception('There is a ' . $method . ' method in the non-' . (string)$class . ' class.');
        }
        return static::$instance->$method(...$args);
    }
}