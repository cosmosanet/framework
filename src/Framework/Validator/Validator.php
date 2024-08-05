<?php
namespace Framework\Validator;

use Error;
use Exception;
use Framework\Traits\RedirectTrait;

class Validator
{
    use RedirectTrait;
    private $requestValue;
    private string $ruleAndArg;
    private string $type;
    private bool $validateStatus = true;
    private array $error = [];
    //@todo подумать как реализовать + сделать возможность наследования от request + Сдеать так чтобы метод отдавал false при провале валидации
    public function __construct(array $rules, mixed $requestValues)
    {
        foreach ($rules as $key => $ruleAndArg) {
            $requestValue = $requestValues[$key];
            $this->requestValue = $requestValue;
            $this->ruleAndArg = $ruleAndArg;
            if (!is_null($this->startValidate($requestValue, $ruleAndArg))) {
                $this->error[$key] = $this->startValidate();
            }
        }
        $_SESSION['error'] = $this->error;
        $error = $this->checkValidateError();
        $this->setValidateStatus($error);
        if (!$this->getValidateStatus()) {
            $_SESSION['old'] = $requestValues;
            $this->redirect($_SERVER['HTTP_REFERER']);
            // return false;
            exit;
        }
    }
    private function setValidateStatus(bool $error): void
    {
        if (!empty($error)) {
            $this->validateStatus = false;
        }
        if (empty($error)) {
            if ($this->validateStatus !== true) {
                $this->validateStatus = true;
            }
        }
    }
    private function checkValidateError(): bool
    {
        return (!empty($_SESSION['error'])) ? true : false;
    }
    public function getValidateStatus(): bool
    {
        return $this->validateStatus;
    }
    private function require()
    {
        if (empty($this->requestValue) && $this->requestValue != '0') {
            return 'Require';
        }
        return true;
    }
    private function int()
    {
        if (is_numeric($this->requestValue)) {
            $this->type = 'int';
            $this->requestValue = (int) $this->requestValue;
            return true;
        } else {
            return 'Is not int';
        }
    }
    private function text(): mixed
    {
        if (is_string($this->requestValue)) {
            $this->type = 'text';
            $this->requestValue = (string) $this->requestValue;
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
    private function regex(int $regex): bool
    {
        return preg_match($regex, $this->requestValue);
    }
    public function startValidate(): ?string
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
        return null;
    }
}