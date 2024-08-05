<?php
namespace Framework\Token;

class Token
{
    public static function genToken(): string
    {
        $token = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );

        return $token;
    }
    public static function setCSRF(): void
    {
        if (!isset($_SESSION['X-CSRF-Token'])) {
            $_SESSION['X-CSRF-Token'] = self::genToken();
        }
    }
    public static function dropCSRF(): void
    {
        unset($_SESSION['X-CSRF-Token']);
    }
    public static function getCSRF(): string
    {
        return $_SESSION['X-CSRF-Token'];
    }
}
