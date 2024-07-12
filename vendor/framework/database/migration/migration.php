<?php
// namespace Framework\Database\Migration;
include_once 'vendor/framework/database/DB.php';
define('DB_LOCATION', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'project');

use Framework\Database\DB;

$db = new DB();
$db->table('zxc');
$db->string('user');
$db->string('surname');

var_dump($db->toSql());