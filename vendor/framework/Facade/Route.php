<?php
namespace Framework\Facade;

use Exception;
use Framework\Routes;

/**
 * @method static void get(string $reqestUrl, string $controllerName, string $functionName)
 * @method static void post(string $reqestUrl, string $controllerName, string $functionName)
 * 
 * @see Framework\Route
 */

final class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
       return Routes::class;
    }
    public static function isExit()
    {
        http_response_code(404);
        throw new Exception('Route ' . $_SERVER['REQUEST_URI'] . ' not found');
    }

}