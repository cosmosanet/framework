<?php

require_once __DIR__ . '/vendor/autoload.php';

use Framework\Handlers\ConsoleHandler;

$console = new ConsoleHandler();
$console->consoleHandler($argv);