<?php
namespace Framework;

use RoutingInterface;

class Request
{
    private string $controllerName;
    private string $methodName;
    private string $httpMethod;
    private string $regexForUrl;
    private array $urlParam = [];
    function __construct(string $controllerName, string $httpMethod, string $routeUrl)
    {
        $this->controllerName = $controllerName;
        $this->httpMethod = $httpMethod;
    }
    public function getRegex(): string
    {
        return $this->regexForUrl;
    }
    public function getProperties(): array
    {

        if (isset($this->urlParam)) {
            $array = [
                'controllerName' => $this->controllerName,
                'methodName' => $this->methodName,
                'httpMethod' => $this->httpMethod,
                'regexForUrl' => $this->regexForUrl,
                'urlParam' => $this->urlParam,
            ];
        } else {
            $array = [
                'controllerName' => $this->controllerName,
                'methodName' => $this->methodName,
                'httpMethod' => $this->httpMethod,
                'regexForUrl' => $this->regexForUrl,
            ];
        }
        return $array;
    }
    public function setUrlNamaesParams(array $namesParam)
    {
        foreach ($namesParam as $item) {
            array_push($this->urlParam, $item);
        }
    }
    public function setMethodName($name)
    {
        $this->methodName = $name;
    }
    public function setValueUrlParam(array $ValuesParam)
    {
        $this->urlParam = array_combine($this->urlParam, $ValuesParam);
    }
    public function setRegex($regex): void
    {
        $this->regexForUrl = $regex;
    }
    public function post(?string $name = null): mixed
    {
        return is_null($name) ? $_POST : $_POST[$name];
    }
    public function get(?string $name = null): mixed
    {
        return is_null($name) ? $_GET : $_GET[$name];
    }
}