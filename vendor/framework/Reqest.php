<?php
namespace Framework;

class Reqest 
{
    private string $controllerName;
    private string $methodName;
    private string $httpMethod;
    private function setControllerName(string $name): void
    {
        $this->controllerName = $name;
    }
    private function setMethodName(string $name): void
    {
        $this->methodName = $name;
    }
    private function setHttpMethod(string $name): void
    {
        $this->httpMethod = $name;
    }
    public function setReqest(string $controller, string $method, string $httpMethod) : void
    {
        $this->setControllerName($controller);
        $this->setMethodName($method);
        $this->setHttpMethod($httpMethod);
    }
    public function getReqest()
    {
        return $this;
    }
}