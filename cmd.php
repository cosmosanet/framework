<?php

$_SERVER['argv'];

switch ($_SERVER['argv'][1]) {
    case 'migrate':
        require_once 'src\Framework\Database\Migration\migration.php';
        break;
    default:
        echo 'Command not found';
        break;
}