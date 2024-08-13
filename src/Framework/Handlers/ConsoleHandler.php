<?php

namespace Framework\Handlers;

class ConsoleHandler
{
    private array $commands;

    //@todo сделать возможность выбора пакета команд
    public function consoleHandler(array $argv, ?string $pathToComands = null): void
    {
        $command = $argv[1] ?? null;
        $args = array_slice($argv, 2);
        $class = $this->getClassForCommandOrHelp($command);
        if ($class) {
            new $class(...$args);
        }
    }

    private function getCommandsArray(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] .'src/Framework/Console/comands.php';
    }

    private function getClassForCommandOrHelp(?string $command)
    {
        require $this->getCommandsArray();
        if (array_key_exists($command, $commands)) {
            return $commands[$command];
        }
        if ($command == null) {
            echo "Available commands: " . PHP_EOL;
            echo implode(PHP_EOL,  $this->getAllComands($commands));
            exit;
        }
        if (!array_key_exists($command, $commands) && $command != null ) {
            echo "Unknown command: " . $command . PHP_EOL;
            echo "Available commands: " . PHP_EOL;
            echo implode(PHP_EOL,  $this->getAllComands($commands));
            exit;
        }
    }

    private function getAllComands (array $commands): array
    {
       return array_keys($commands);
    }
}
