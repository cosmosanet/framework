<?php

define('DB_LOCATION', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'project');
define('DEV_MODE', true);
// define('DEV_MODE', FALSE);
try {
    try {
        require_once __DIR__ . '/vendor/autoload.php';
    } catch (Error $e) {
        if (DEV_MODE === true) {
            $exceptionType = str_replace('Exception\\', '', get_class($e));
            $exceptionMassage = $e->getMessage();
            $exceptionFile = $e->getFile();
            $exceptionLine = $e->getLine();
            $exceptionTrace = $e->getTrace();
            include_once 'vendor\framework\CoreFunc.php';
            require_once 'ExeptionPage.php';
        } else {
                http_response_code(500);
        }
    }
} catch (Exception $e) {
    if (DEV_MODE === true) {
        $exceptionType = str_replace('Exception\\', '', get_class($e));
        $exceptionMassage = $e->getMessage();
        $exceptionFile = $e->getFile();
        $exceptionLine = $e->getLine();
        $exceptionTrace = $e->getTrace();
        include_once 'vendor\framework\CoreFunc.php';
        require_once 'ExeptionPage.php';
    } else {
        $exceptionType = str_replace('Exception\\', '', get_class($e));
        if ($exceptionType === 'RouteException') {
            http_response_code(404);
        } 
        if ($exceptionType === 'CSRFException') {
            http_response_code(401);
        } 
    }

}