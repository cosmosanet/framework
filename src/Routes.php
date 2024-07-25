<?php
namespace Framework;

<<<<<<< HEAD
=======
<<<<<<<< HEAD:src/Framework/Routes.php

========
>>>>>>>> origin:src/Routes.php
>>>>>>> origin
use Exception\CSRFException;
use Exception\RouteException;
use Framework\Request;

class Routes
{
    private string $urlRegex;
    private Request $request;

    public function get(string $requestUrl, string $controllerName): Routes
    {
        $this->request = new Request($controllerName, 'GET', $requestUrl);
        $this->urlRegex = $this->getRegexForUrl($requestUrl);
        $this->request->setUrlNamaesParams($this->getUrlNameParamIfExist($requestUrl));
        $this->request->setRegex($this->urlRegex);
        return $this;
    }
    public function post(string $requestUrl, string $controllerName): Routes
    {
        $this->request = new Request($controllerName, 'POST', $requestUrl);
        $this->urlRegex = $this->getRegexForUrl($requestUrl);
        $this->request->setUrlNamaesParams($this->getUrlNameParamIfExist($requestUrl));
        $this->request->setRegex($this->urlRegex);
        if($this->checkRequest())
        {
            $this->checkAuthorized();
        }
        return $this;
    }
    private function checkAuthorized()
    {
       if ($this->request->getCSRF() === getCSRF()){
        dropCSRF();
        return;
       } else {
        throw new CSRFException('Route unauthorized');
       }
    }
    public function name(string $nameMethod): void
    {
        if ($this->checkRequest()) {
            $this->request->setMethodName($nameMethod);
            $this->start();
            exit;
        }
    }
    public function middleware(mixed $middlewares): Routes
    {

        if ($this->checkRequest()) {
            if (is_array($middlewares)) {
                foreach ($middlewares as $middleware) {
                    $class = new $middleware();
                    foreach (get_class_methods($middleware) as $method) {
                        $this->request = $class->$method($this->request);
                    }
                }
            }
            if (is_string($middlewares)) {
                $class = new $middlewares();
                foreach (get_class_methods($middlewares) as $method) {
                    $this->request = $class->$method($this->request);
                }
            }
        }
        return $this;
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
            if (is_string($param)) {
                $regex = str_replace($param, '(\w+)', $regex);
            }
            if (is_int($param)) {
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
                $paramArray[$name] = $this->request;
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
        return (string) $url;
    }
    private function getRequestIfExist(string $url): ?Request
    {
        if (preg_match($this->urlRegex, $url)) {
                    return $this->request;
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
        if ($httpServerMethod !== $http) {
            throw new RouteException('The route does not support the ' . $httpServerMethod . ' method');
        }
        return false;
    }
    private function checkMetodExist(string $class, string $method): bool
    {
        if (class_exists($class)) {
            if (method_exists($class, $method)) {
                return true;
            }
            if (!method_exists($class, $method)) {
                throw new RouteException('Method ' . $method . ' not found');
            }
        }
        if (!class_exists($class)) {
            throw new RouteException('Class ' . $class . ' not found');
        }
        return false;
    }
    private function callMethod(string $class, string $method, string $regex, array $urlParam): void
    {
        $paramArray = $this->getParam($class, $method, $regex, $urlParam);
        $callMethod = new $class;
        $callMethod->$method(...$paramArray);
    }
    private function checkRequest(): bool
    {
        $url = $this->getMainUrl($_SERVER['REQUEST_URI']);
            if (preg_match($this->urlRegex, $url)) {
                return true;
            } else return false;
    }
    private function start(): void
    {
        $mainurl = $this->getMainUrl($_SERVER['REQUEST_URI']);
        $request = $this->getRequestIfExist($mainurl);
        if ($request !== null) {
            $this->checkHttpMethod();
            $properties = $request->getProperties();
            $class = $properties['controllerName'];
            $method = $properties['methodName'];
            $regex = $properties['regexForUrl'];
            $this->checkMetodExist($class, $method);
            $request->setValueUrlParam($this->getValueUrlParam($mainurl, $regex));
            if (isset($properties['urlParam'])) {
                $urlParam = $request->getProperties()['urlParam'];
            }
            $this->callMethod($class, $method, $regex, $urlParam);
            return;
        }
        return;
    }
}