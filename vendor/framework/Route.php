<?php
namespace Framework;

use Framework\Request;

class Route
{
    private static array $route = [];
    public static function get(string $reqestUrl, string $controllerName, string $functionName): void
    {
        $reqest = new Request($controllerName, $functionName, 'GET', $reqestUrl);
        self::$route[$reqestUrl] = $reqest;
    }
    public static function post(string $reqestUrl, string $controllerName, string $functionName): void
    {
        $reqest = new Request($controllerName, $functionName, 'POST', $reqestUrl);
        self::$route[$reqestUrl] = $reqest;
    }
    private static function getMethodParam(string $class, string $method, $mainurl): array
    {
        $paramArray = [];
        $searchMethod = new \ReflectionMethod($class, $method);
        foreach ($searchMethod->getParameters() as $item) {
            if($item->getType()->__tostring() === 'Framework\Request'){
                $name = $item->getName();
                $paramArray[$name] = self::$route[$mainurl];
            } else {
                $name = $item->getName();
                $item->isDefaultValueAvailable() ? $paramArray[$name] = $item->getDefaultValue() : $paramArray[$name] = null;
            }
        }
        return $paramArray;
    }
    private static function getMainUrl(string $serverUrl) 
    {
        return parse_url($serverUrl)['path'];
    }
    private static function urlParam()
    {

    }
    public static function start(): void
    {
        $serverUrl = $_SERVER['REQUEST_URI'];
        $httpServerMethod = $_SERVER['REQUEST_METHOD'];
        $mainurl = self::getMainUrl($_SERVER['REQUEST_URI']);
        if (array_key_exists($mainurl, self::$route)) {
            $reqest = self::$route[$mainurl]->getReqest();
            $class = $reqest['controllerName'];
            $method = $reqest['methodName'];
            $http = $reqest['httpMethod'];
            if ($httpServerMethod === $http) {
                if (class_exists($class)) {
                    if (method_exists($class, $method)) {
                        $paramArray = self::getMethodParam($class, $method, $mainurl);
                        $callMethod = new $class;
                        $callMethod->$method(...$paramArray);
                    } else {
                        echo "Method " . $method . " does not exist";
                        //@toDo Нужно сделать редирект на страницу с ошибками
                    }
                } else {
                    echo "Class " . $class . "does not exist";
                    //@toDo Нужно сделать редирект на страницу с ошибками
                }
            } else {
                http_response_code(405);
            }

        } else {
            http_response_code(404);
        }
    }
}