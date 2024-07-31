<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

use Framework\Database\DB;
use Framework\Env\Env;


new Env('.env');

$db = new DB();
$db->table('zxc');
$db->string('user');
$db->string('surname');
try {
    $db->create();
} catch (mysqli_sql_exception $e) {
    echo $e;
}

// $dir = __DIR__ ; // убедитесь, что директория указана правильно

// foreach (glob($dir . '/*.php') as $fileName) {
//     echo basename($fileName), "\n";
// }
//@todo Сделать миграции