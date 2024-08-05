<?php
namespace Framework\Http;

use Exception;
use Exception\CSRFException;
use Framework\Traits\RedirectTrait;
use Framework\Validator\Validator;

class Request
{
    use RedirectTrait;
    private string $controllerName;
    private string $methodName;
    private string $httpMethod;
    private string $regexForUrl;
    private string $token;
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
    public function getToken(): string
    {
        return $this->token;
    }
    public function setToken(string $token): void
    {
        $this->token = $token;
        ;
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
    public function setUrlNamaesParams(array $namesParam): void
    {
        foreach ($namesParam as $item) {
            array_push($this->urlParam, $item);
        }
    }
    public function setMethodName($name): void
    {
        $this->methodName = $name;
    }
    public function setValueUrlParam(array $ValuesParam): void
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
    public function getCSRF(): mixed
    {
        if (isset($_POST['X-CSRF-Token'])) {
            return $_POST['X-CSRF-Token'];
        }
        if (isset($_GET['X-CSRF-Token'])) {
            return $_GET['X-CSRF-Token'];
        }
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $serverUrl = $_SERVER['REQUEST_URI'];
        throw new CSRFException('HTTP ' . $httpMethod . ' request ' . $serverUrl . ' does not have CSRF token.');
    }
    private function getRequestValues(?string $key = null): mixed
    {
        $httpMethod = strtolower($this->httpMethod);
        return $this->$httpMethod($key);
    }

    public function validate(array $rules, ?array $massages = null): ?bool
    {
        $validator = new Validator($rules, $this->getRequestValues());
        return $validator->getValidateStatus();
    }
}