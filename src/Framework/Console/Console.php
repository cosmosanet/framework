<?php

namespace Framework\Console;

abstract class Console
{
    protected string $value;
    protected array $operations;

    public function __construct(string $value,...$args)
    {
        $this->value = $value;
        foreach ($args as $arg) {
            $explodeArg = explode(':', $arg);
            $method = $this->getMethodOrHelp($explodeArg[0]);
            isset($explodeArg[1]) ? $this->$method($explodeArg[1]) : $this->$method();
        }
        $this->execCommand();
    }

    protected function getMethodOrHelp (string $arg) 
    {
        if (array_key_exists($arg, $this->operations)) {
            return $this->operations[$arg];
        }
        if (!array_key_exists($arg, $this->operations)) {
            echo 'Unknown operator: ' . $arg . PHP_EOL;
            echo "Available operators: " . PHP_EOL;
            echo implode(PHP_EOL,  $this->getAllOpetators());
            exit;
        }
    }

    protected function getAllOpetators (): array
    {
       return array_keys($this->operations);
    }

    abstract protected function execCommand();
}