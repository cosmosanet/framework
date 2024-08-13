<?php
use Framework\Facade\Application;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

session_start();
Application::setCSRF();
Application::setEnv();
Application::ThrowableHandler();