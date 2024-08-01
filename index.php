<?php

require_once __DIR__ . '/vendor/autoload.php';

use Framework\Env\Env;

new Env(null);
try {
    try {
        require_once __DIR__ . '/bootstrap/bootstrap.php';
    } catch (Error $e) {
        if (DEV_MODE == 'true') {
            $exceptionType = str_replace('Exception\\', '', get_class($e));
            $exceptionMassage = $e->getMessage();
            $exceptionFile = $e->getFile();
            $exceptionLine = $e->getLine();
            $exceptionTrace = $e->getTrace();
            require_once __DIR__ . '/src/Framework/CoreFunc.php';
            require_once __DIR__ . '/ExeptionPage.php';
        } else {
                http_response_code(500);
        }
    }
} catch (Exception $e) {
    if (DEV_MODE == 'true') {
        $exceptionType = str_replace('Exception\\', '', get_class($e));
        $exceptionMassage = $e->getMessage();
        $exceptionFile = $e->getFile();
        $exceptionLine = $e->getLine();
        $exceptionTrace = $e->getTrace();
        require_once __DIR__ . '/src/Framework/CoreFunc.php';
        require_once __DIR__ . '/ExeptionPage.php';
    } else {
        $exceptionType = str_replace('Exception\\', '', get_class($e));
        if (method_exists($e, 'getHttpStatus')) {
            http_response_code($e->getHttpStatus());
        }
    }
    //@todo сделать нормальный класс

}