<?php

namespace Framework\Facade;

use Exception;

class Facade
{
    protected static function getFacadeAccessor()
    {
        throw new Exception('Facade does not implement getFacadeAccessor method.');
    }
    protected static function getInstance(): object
    {
        $name = static::getFacadeAccessor();
        if (!class_exists($name)) {
            throw new Exception('The facade of the class does not exist.');
        }
        $instance = new $name();
        return $instance;
    }
    protected static function getInstanceClassName()
    {
        
    }
    public static function __callStatic($method, $args)
    {
        $name = static::getFacadeAccessor();
        if (!method_exists($name, $method)) {
            throw new Exception('There is a ' . $method . ' method in the non-' . $name . ' class.');
        }
        $instance = static::getInstance();
        return $instance->$method(...$args);
    }
}