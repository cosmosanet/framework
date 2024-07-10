<?php
namespace Framework;
class Route {
    private static array $route = [];
    public static function make(string $reqest, string $controllerName, string $functionName) : void 
    {
        self::$route[$reqest] = [$controllerName, $functionName];
    }
    private static function get($key): ?array 
    {
        if (array_key_exists($key, self::$route)) {
            return self::$route[(string)$key];
        } else {
            echo "Route " . $key . " does not exist";
            return null;
            //Нужно сделать редирект на страницу с ошибками
        }
    }
    public static function start(): void 
    {
        $url = $_SERVER['REQUEST_URI'];
        $mainurl = strtok($url, '?');
        $mvc = self::get($mainurl);
        $class = $mvc[0];
        if(class_exists($class)) {
            $metod = $mvc[1];
            if(method_exists($class, $metod)) {
                $asd = new $class;
                $asd->$metod();
            } else {
                echo "Metod " . $metod . " does not exist";
                //Нужно сделать редирект на страницу с ошибками
            }
        } else {
            echo "Class " . $class . "does not exist";
            //Нужно сделать редирект на страницу с ошибками
        }
    }
}