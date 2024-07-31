<?php
namespace Framework\Validator;

use Framework\Traits\RedirectTrait;

class Validator
{
    use RedirectTrait;
    private $requestValue;
    private string $ruleAndArg;
    private string $type;
    private string $errors;

    public function __construct(mixed $requestValue, string $ruleAndArg)
    {
        $this->requestValue = $requestValue;
        $this->ruleAndArg = $ruleAndArg;
    }
    private function require(): mixed
    {
        return empty($this->requestValue) ? 'Is not require' : true;
    }
    private function int(): mixed
    {
        if (is_numeric($this->requestValue)) {
            $this->type = 'int';
            $this->requestValue = (int)$this->requestValue;
            return true;
        } else {
            return 'Is not int';
        }
    }
    private function text(): mixed
    {
        if (is_string($this->requestValue)) {
            $this->type = 'text';
            $this->requestValue = (string)$this->requestValue;
            return true;
        } else {
            return 'Is not text';
        }
    }
    private function max(int $count): mixed
    {
        switch ($this->type) {
            case 'text':
                return strlen($this->requestValue) <= $count ? true : 'Value is too high';
                break;
            case 'int':
                return $this->requestValue <= $count ? true : 'Value is too high';
                break;
            default:
                return strlen($this->requestValue) <= $count ? true : 'Value is too high';
        }
    }
    private function min(int $count): mixed
    {
        switch ($this->type) {
            case 'text':
                return mb_strlen($this->requestValue, 'UTF-8') >= $count ? true : 'Value too small';
                break;
            case 'int':
                return $this->requestValue >= $count ? true : 'Value too small';
                break;
            default:
                return strlen($this->requestValue) >= $count ? true : 'Value too small';
        }
    }
    private function regex(int $regex): mixed
    {
        return preg_match($regex, $this->requestValue);
    }
    public function startValidate()
    {
        foreach (explode('|', $this->ruleAndArg) as $item) {
            $rule = explode(':', $item);
            $action = $rule[0];
            if (isset($rule[1])) {
                if ($this->$action($rule[1]) !== true) {
                    return $this->$action($rule[1]);
                }
            } else {    
                if ($this->$action() !== true) {
                    return $this->$action();
                }
            }
        }
    }
}