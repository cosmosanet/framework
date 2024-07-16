<?php
namespace Framework;
final class RoutingFacade 
{
    private static $roathing;

    public static function construct(RoutingInterface $roathing)
    {
        self::$roathing = $roathing;
    }

    public static function get(string $reqestUrl, string $controllerName, string $functionName): void
    {
        self::$roathing::get($reqestUrl, $controllerName, $functionName);
    }
    public static function post(string $reqestUrl, string $controllerName, string $functionName): void
    {
        self::$roathing::post($reqestUrl, $controllerName, $functionName);
    }
    public static function start(): void
    {
        self::$roathing::start();
    }
}