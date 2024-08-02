<?php

require_once $_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php';

use Framework\Facade\Application;
// Application::setCSRF();
Application::setEnv();
Application::ThrowableHandler();
