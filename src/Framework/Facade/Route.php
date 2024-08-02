<?php
namespace Framework\Facade;

use Exception\RouteException;
use Framework\Http\Routes;

/**
 * @method static Routes get(string $reqestUrl, string $controllerName)
 * @method static Routes post(string $reqestUrl, string $controllerName)
 * @method void name(string $nameMethod)
 * @method int getCount()
 * 
 * @see Framework\Http\Route
 */

final class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
       return Routes::class;
    }
    public static function isExit()
    {
        throw new RouteException('Route ' . $_SERVER['REQUEST_URI'] . ' not found');
    }

}