<?php
namespace Framework;

use Framework\Request;

class Route
{
    private static array $route = [];
    public static function get(string $reqestUrl, string $controllerName, string $functionName): void
    {
        $reqest = new Request($controllerName, $functionName, 'GET', $reqestUrl);
        $regex = self::getRegexForUrl($reqestUrl);
        $param = self::getUrlNameParamIfExist($reqestUrl);
        if ($param !== null) {
            $reqest->setUrlNamaesParams(self::getUrlNameParamIfExist($reqestUrl));
        }
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
    private static function getUrlNameParamIfExist($url): ?array
    {
        if (preg_match('/\{([^}]*)\}/', $url)) {
            preg_match_all('/\{([^}]*)\}/', $url, $array);
            return $array[1];
        } else return null;
    }
    private static function getRegexForUrl(string $url): string
    {
        preg_match_all('/\{([^}]*)\}/', $url, $array);
        $regex = $url;
        foreach($array[0] as $param) {
            $regex = str_replace($param, '(.*?)', $regex);
        }
        $regex = str_replace('/', '\/', $regex);
        //@todo Сделать возможность добавлять url без / в конце
        return '/' . $regex . '/';
    }
    private static function getParam(string $class, string $method, string $regex, ?array $urlParam): array
    {
        $paramArray = [];
        $searchMethod = new \ReflectionMethod($class, $method);
        foreach ($searchMethod->getParameters() as $item) {
            $name = $item->getName();
            if((string)$item->getType() === 'Framework\Request'){
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
        return parse_url($serverUrl)['path'];
    }
    private static function getMvcIfExist(string $url): ?Request
    {
        foreach (self::$route as $key => $value) {
        if(preg_match($key, $url))
        {
            preg_match($key, $url, $array);
            return $value;
        } else {
            return null;
        }
        }
    }
    private static function getValueUrlParam($url, $regex): array
    {
        preg_match($regex, $url, $arr);
        array_shift($arr);
        return $arr;
    }
    public static function start(): void
    {
        $httpServerMethod = $_SERVER['REQUEST_METHOD'];
        $mainurl = self::getMainUrl($_SERVER['REQUEST_URI']);
        $mvc = self::getMvcIfExist($mainurl);
        if($mvc === null) {
            http_response_code(404);
        } else {
            $reqest = $mvc->getReqest();
            $class = $reqest['controllerName'];
            $method = $reqest['methodName'];
            $http = $reqest['httpMethod'];
            $regex = $reqest['regexForUrl'];
            if ($httpServerMethod === $http) {
                if (class_exists($class)) {
                    if (method_exists($class, $method)) {
                        $mvc->setValueUrlParam(self::getValueUrlParam($mainurl, $regex));
                        if (isset($reqest['urlParam'])) {
                            $urlParam = $mvc->getReqest()['urlParam'];
                        }
                        $paramArray = self::getParam($class, $method, $regex, $urlParam);
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
        }
    }
}