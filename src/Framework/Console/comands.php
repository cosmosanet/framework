<?php

use Framework\Console\ModelMaker\ModelMaker;
use Framework\Console\Printer\ConsolePriner;

$commands = [
  "print" => ConsolePriner::class,
  "mkmodel" => ModelMaker::class
];