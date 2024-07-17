<?php
namespace Framework;

use Exception;
use Framework\Request;

class Routes
{
    private array $route = [];
    private Request $reqest;

    public function get(string $reqestUrl, string $controllerName, string $functionName): void
    {
        $reqest = new Request($controllerName, $functionName, 'GET', $reqestUrl);
        $regex = $this->getRegexForUrl($reqestUrl);
        $reqest->setUrlNamaesParams($this->getUrlNameParamIfExist($reqestUrl));
        $reqest->setRegex($regex);
        $this->route[$regex] = $reqest;
        if ($this->start()) {
            exit;
        }
    }
    public function post(string $reqestUrl, string $controllerName, string $functionName): void
    {
        $reqest = new Request($controllerName, $functionName, 'POST', $reqestUrl);
        $regex = $this->getRegexForUrl($reqestUrl);
        $reqest->setUrlNamaesParams($this->getUrlNameParamIfExist($reqestUrl));
        $reqest->setRegex($regex);
        $this->route[$regex] = $reqest;
        if ($this->start()) {
            exit;
        } 
    }
    private function getUrlNameParamIfExist(string $url): ?array
    {
        if (preg_match('/\{([^}]*)\}/', $url)) {
            preg_match_all('/\{([^}]*)\}/', $url, $array);
            return $array[1];
        } 
        if (!preg_match('/\{([^}]*)\}/', $url)) {
            return $array = [];
        }
    }
    private function getRegexForUrl(string $url): string
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
    private function getParam(string $class, string $method, string $regex, ?array $urlParam): array
    {
        $paramArray = [];
        $searchMethod = new \ReflectionMethod($class, $method);
        foreach ($searchMethod->getParameters() as $item) {
            $name = $item->getName();
            if ((string) $item->getType() === 'Framework\Request') {
                $paramArray[$name] = $this->route[$regex];
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
    private function getMainUrl(string $serverUrl): string
    {
        $url = parse_url($serverUrl)['path'];
        $url = $url . '/';
        $url = str_replace('//', '/', $url);
        return (string)$url;
    }
    private function getRequestIfExist(string $url): ?Request
    {
        foreach ($this->route as $key => $value) {
            if (preg_match($key, $url)) {
                return $value;
            }
        }
        return null;
    }
    private function getValueUrlParam($url, $regex): array
    {
        preg_match($regex, $url, $arr);
        array_shift($arr);
        return $arr;
    }
    private function checkHttpMethod(): bool
    {
        $reqest = $this->getRequestIfExist($this->getMainUrl($_SERVER['REQUEST_URI']));
        $httpServerMethod = $_SERVER['REQUEST_METHOD'];
        $http = $reqest->getProperties()['httpMethod'];
        if ($httpServerMethod === $http) {
            return true;
        } 
        if ($httpServerMethod !== $http)  {
            http_response_code(405);
            throw new Exception('The route does not support the ' . $httpServerMethod . ' method');
        }
    }
    private function checkMetodExist(string $class, string $method): bool
    {
        if (class_exists($class)) {
            if (method_exists($class, $method)) {
                return true;
            } 
            if (!method_exists($class, $method)) {
                http_response_code(404);
                throw new Exception('Method ' . $method .  ' not found');
            }
        } 
        if (!class_exists($class)) {
            http_response_code(404);
            throw new Exception('Class ' . $class . ' not found');
        }
    }
    private function callMethod(string $class, string $method, string $regex, array $urlParam): void
    {
        $paramArray = $this->getParam($class, $method, $regex, $urlParam);
        $callMethod = new $class;
        $callMethod->$method(...$paramArray);
    }
    private function start(): bool
    {
        $mainurl = $this->getMainUrl($_SERVER['REQUEST_URI']);
        $request = $this->getRequestIfExist($mainurl);
        if ($request !== null) {
            $this->checkHttpMethod();
            $reqest = $request->getProperties();
            $class = $reqest['controllerName'];
            $method = $reqest['methodName'];
            $regex = $reqest['regexForUrl'];
            $this->checkMetodExist($class, $method);
            $request->setValueUrlParam($this->getValueUrlParam($mainurl, $regex));
            if (isset($reqest['urlParam'])) {
                $urlParam = $request->getProperties()['urlParam'];
            }
            $this->callMethod($class, $method, $regex, $urlParam);
            return true;
        }
            return false;
    }
}


// class Route
// {
//     private Request $request;
//     public function get(): Route
//     {
//         $this->request = new Request();
//         return $this;
//     }

//     public function middleware($middlewares): Route
//     {
//         foreach ($middlewares as $middleware)
//         {
//             // что то делает с $this->$request
//         }
//         return $this;
//     }

//     public function name($nameMethod): void
//     {
//         if($this->start()) {
//             exit;
//         }
//     }

//     public function start($nameMethod): bool
//     {
//         //выполнение роута
//     }
// }

// //ИТОГ
// Route::get()->middleware($middlewares)->name($nameMethod);