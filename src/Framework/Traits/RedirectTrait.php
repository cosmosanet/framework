<?php
namespace Framework\Traits;

trait RedirectTrait
{
    public function redirect(string $url): void
    {
        header('Location: ' . $url);
    }
}