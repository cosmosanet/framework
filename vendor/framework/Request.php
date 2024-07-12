<?php
namespace Framework;

class Request 
{
    private string $controllerName;
    private string $methodName;
    private string $httpMethod;
    private string $mainUrl;
    private array $urlParam;
    function __construct(string $controllerName, string $methodName, string $httpMethod, string $routeUrl) {
        $this->controllerName = $controllerName;
        $this->methodName = $methodName;
        $this->httpMethod = $httpMethod;
        $this->mainUrl = explode('{', $routeUrl)[0];
        preg_match_all('/\{([^}]*)\}/', $routeUrl, $matches);
        foreach($matches[1] as $param)
        {
            $urlParam[$param] = null;
        }
        // var_dump($urlParam);
        // var_dump(explode('{', $routeUrl));
    } 
    public function getReqest(): array
    {

        if (isset($this->urlParam)){
            $array = [
                'controllerName' => $this->controllerName,
                'methodName' => $this->methodName,
                'httpMethod' => $this->httpMethod,
                'mainUrl' => $this->mainUrl,
                'urlParam' => $this->urlParam,
            ];
        } else {
            $array = [
                'controllerName' => $this->controllerName,
                'methodName' => $this->methodName,
                'httpMethod' => $this->httpMethod,
                'mainUrl' => $this->mainUrl,
                // 'urlParam' => $this->urlParam,
            ];
        }
       return $array;
    }
    public function post(?string $name = null): mixed {
        return is_null($name)? $_POST : $_POST[$name];
    }
    public function get(?string $name = null): mixed {
        return is_null($name)? $_GET : $_GET[$name];
    }
} 