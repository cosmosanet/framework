<?php

namespace Framework\Facade;

use Exception;

class Facade
{
    protected static function getFacadeAccessor()
    {
        throw new Exception('Facade does not implement getFacadeAccessor method.');
    }
    protected static function getInstance(string $method): object
    {
        $аccessor = static::getFacadeAccessor();
        $className = static:: getClassForMethodOrFail($аccessor, $method);
        $instance = new $className();
        return $instance;
    }
    protected static function getClassForMethodOrFail(mixed $аccessor, string $method): string
    {
        if (is_array($аccessor)) {
            foreach ($аccessor as $аccessorItem) {
                if (static::checkClass($аccessorItem) && static::checkMethod($аccessorItem, $method)) {
                    return $аccessorItem;
                } 
                if (!static::checkClass($аccessorItem)) {
                    throw new Exception('The facade of the class does not exist.');
                }
            }
            throw new Exception('Unidentified method:' . $method . '.');
        } 
        if (is_string($аccessor)) {
            if (static::checkClass($аccessor) && static::checkMethod($аccessor, $method)) {
                return $аccessor;
            } 
            if (!static::checkClass($аccessor)) {
                throw new Exception('The facade of the class does not exist.');
            }
            throw new Exception('Unidentified method:' . $method . '.');
        }

    }
    protected static function checkClass(string $class): bool
    {
        return class_exists($class) ? true : false;
    }
    protected static function checkMethod(string $class, string $method)
    {
        return method_exists($class, $method) ? true : false;
    }
    public static function __callStatic($method, $args)
    {
        $instance = static::getInstance($method);
        return $instance->$method(...$args);
    }
}