<?php
namespace Framework\Facade;

use Framework\Env\Env;
use Framework\Handlers\ThrowableHandler;
use Framework\Token\Token;

/**
 * @method static void setEnv(?string $pathToEnv = nulll)
 * @method static void ThrowableHandler()
 * @method static void setCSRF()
 * @method static void dropCSRF()
 * @method static string getCSRF()
 * 
 * @see Framework\Env\Env
 * @see Framework\ThrowableHandler
 */


final class Application extends Facade
{
    protected static function getFacadeAccessor(): array
    {
       return [ThrowableHandler::class, Env::class, Token::class];
    }

    public function bootstrap(): void
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap/bootstrap.php';
    }
}