<?php
namespace Framework\Facade;

use Framework\Routes;

/**
 * @method static void get(string $reqestUrl, string $controllerName, string $functionName)
 * @method static void start()
 * @method static void post(string $reqestUrl, string $controllerName, string $functionName)
 * @see Framework\Route
 */

final class Route extends Facade
{
    public static function getFacadeAccessor()
    {
       return Routes::class;
    }
}