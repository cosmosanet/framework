<?php
namespace Framework;
interface RoutingInterface {
    public static function get(string $reqestUrl, string $controllerName, string $functionName): void;
    public static function post(string $reqestUrl, string $controllerName, string $functionName): void;
    public static function start(): void;
}
