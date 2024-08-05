<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Framework\Facade\Application;

session_start();
Application::setCSRF();
Application::setEnv();
Application::ThrowableHandler();
