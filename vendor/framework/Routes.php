<?php
namespace Framework;

use Exception;
use Framework\Request;

class Routes
{
    private static array $route = [];
    public static function get(string $reqestUrl, string $controllerName, string $functionName): void
    {
        $reqest = new Request($controllerName, $functionName, 'GET', $reqestUrl);
        $regex = self::getRegexForUrl($reqestUrl);
        $reqest->setUrlNamaesParams(self::getUrlNameParamIfExist($reqestUrl));
        $reqest->setRegex($regex);
        self::$route[$regex] = $reqest;
    }
    public static function post(string $reqestUrl, string $controllerName, string $functionName): void
    {
        $reqest = new Request($controllerName, $functionName, 'POST', $reqestUrl);
        $regex = self::getRegexForUrl($reqestUrl);
        $reqest->setRegex($regex);
        self::$route[$regex] = $reqest;
    }
    private static function getUrlNameParamIfExist(string $url): ?array
    {
        if (preg_match('/\{([^}]*)\}/', $url)) {
            preg_match_all('/\{([^}]*)\}/', $url, $array);
            return $array[1];
        } else
            return $array = [];
    }
    private static function getRegexForUrl(string $url): string
    {
        preg_match_all('/\{([^}]*)\}/', $url, $array);
        $regex = $url;
        foreach ($array[0] as $param) {
            if(is_string($param)) {
                $regex = str_replace($param, '(\w+)', $regex);
            }
            if(is_int($param))
            {
                $regex = str_replace($param, '(\d+)', $regex);
            }
        }
        $regex = str_replace('/', '\/', $regex);
        $regex = $regex . '\/+$';
        $regex = str_replace('\/\/', '\/', $regex);
        return '/^' . $regex . '/';
    }
    private static function getParam(string $class, string $method, string $regex, ?array $urlParam): array
    {
        $paramArray = [];
        $searchMethod = new \ReflectionMethod($class, $method);
        foreach ($searchMethod->getParameters() as $item) {
            $name = $item->getName();
            if ((string) $item->getType() === 'Framework\Request') {
                $paramArray[$name] = self::$route[$regex];
            } else if (isset($urlParam)) {
                if (array_key_exists($name, $urlParam)) {

                    $paramArray[$name] = $urlParam[$name];
                }
            } else {
                $item->isDefaultValueAvailable() ? $paramArray[$name] = $item->getDefaultValue() : $paramArray[$name] = null;
            }
        }
        return $paramArray;
    }
    private static function getMainUrl(string $serverUrl): string
    {
        $url = parse_url($serverUrl)['path'];
        $url = $url . '/';
        $url = str_replace('//', '/', $url);
        return (string)$url;
    }
    private static function getRequestIfExist(string $url): ?Request
    {
        
        foreach (self::$route as $key => $value) {
            if (preg_match($key, $url)) {
                return $value;
            }
        }
        return null;
    }
    private static function getValueUrlParam($url, $regex): array
    {
        preg_match($regex, $url, $arr);
        array_shift($arr);
        return $arr;
    }
    private static function checkHttpMethod(): bool
    {
        $reqest = self::getRequestIfExist(self::getMainUrl($_SERVER['REQUEST_URI']));
        $httpServerMethod = $_SERVER['REQUEST_METHOD'];
        $http = $reqest->getProperties()['httpMethod'];
        if($httpServerMethod === $http) {
            return true;
        } else {
            http_response_code(405);
            throw new Exception('The route does not support the ' . $httpServerMethod . ' method');
        }
    }
    private static function checkMetodExist(string $class, string $method): bool
    {
        if (class_exists($class)) {
            if (method_exists($class, $method)) {
                return true;
            } else {
                http_response_code(404);
                throw new Exception('Method ' . $method .  ' not found');
            }
        } else {
            http_response_code(404);
            throw new Exception('Class ' . $class . ' not found');
        }
    }
    private static function callMethod(string $class, string $method, string $regex, array $urlParam): void
    {
        $paramArray = self::getParam($class, $method, $regex, $urlParam);
        $callMethod = new $class;
        $callMethod->$method(...$paramArray);
    }
    public static function start(): void
    {
        $mainurl = self::getMainUrl($_SERVER['REQUEST_URI']);
        $request = self::getRequestIfExist($mainurl);
        if ($request !== null) {
            self::checkHttpMethod();
            $reqest = $request->getProperties();
            $class = $reqest['controllerName'];
            $method = $reqest['methodName'];
            $regex = $reqest['regexForUrl'];
            self::checkMetodExist($class, $method);
            $request->setValueUrlParam(self::getValueUrlParam($mainurl, $regex));
            if (isset($reqest['urlParam'])) {
                $urlParam = $request->getProperties()['urlParam'];
            }
            self::callMethod($class, $method, $regex, $urlParam);
        }
        if ($request === null) {
            http_response_code(404);
            throw new Exception('Route ' . $mainurl . ' not found');
        }
    }
}