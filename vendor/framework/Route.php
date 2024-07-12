<?php
namespace Framework;

use Framework\Reqest;
class Route
{
    private static array $route = [];
    public static function make(string $reqest, string $controllerName, string $functionName): void
    {
        self::$route[$reqest] = [$controllerName, $functionName];
    }
    public static function get(string $reqestUrl, string $controllerName, string $functionName): void
    {
        $reqest = new Reqest();
        $reqest->setReqest($controllerName, $functionName, 'GET');
        self::$route[$reqestUrl] = $reqest;
    }
    public static function post(string $reqestUrl, string $controllerName, string $functionName): void
    {
        $reqest = new Reqest();
        $reqest->setReqest($controllerName, $functionName, 'POST');
        self::$route[$reqestUrl] = $reqest;
    }
    private static function getMvc($key): ?array
    {
        if (array_key_exists($key, self::$route)) {
            return self::$route[(string) $key];
        } else {
            echo "Route " . $key . " does not exist";
            return null;
            //@toDo Нужно сделать редирект на страницу с ошибками
        }
    }
    public static function start(): void
    {
        $url = $_SERVER['REQUEST_URI'];
        $mainurl = strtok($url, '?');
        $mvc = self::getMvc($mainurl);
        $class = $mvc[0];
        if (class_exists($class)) {
            $method = $mvc[1];
            if (method_exists($class, $method)) {
                $searchMethod = new \ReflectionMethod($class, $method);
                $paramArray = [];
                
                foreach($searchMethod->getParameters() as $item)
                {
                    $name = $item->getName();
                    $item->isDefaultValueAvailable() ? $paramArray[$name] = $item->getDefaultValue() : $paramArray[$name] = null;
                }
                $callMethod = new $class;
                $callMethod->$method(...$paramArray);
                //@todo Сделать возможность передачи параметров при get запросе
            } else {
                echo "Method " . $method . " does not exist";
                //@toDo Нужно сделать редирект на страницу с ошибками
            }
        } else {
            echo "Class " . $class . "does not exist";
            //@toDo Нужно сделать редирект на страницу с ошибками
        }
    }
}