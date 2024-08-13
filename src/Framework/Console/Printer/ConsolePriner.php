<?php

namespace Framework\Console\Printer;

use Framework\Console\Console;

class ConsolePriner extends Console
{
    protected array $operations = [
        '-u' => 'toUp',
        '--toup' => 'toUp',
    ];

    protected function toUp(): void
    {
        $this->value = strtoupper($this->value);
    }

    protected function execCommand(): void 
    {
        echo $this->value;
    }
}