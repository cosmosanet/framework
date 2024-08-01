<?php

namespace App\Controllers;
use Framework\Traits\RedirectTrait;

class Controller
{
    use RedirectTrait {
        RedirectTrait::redirect as standartRedirect;
    }
    public function view(string $name, ?array $arg = null): Controller
    {
        include_once 'resources/view/layout/head.php';
        include_once $_SERVER['DOCUMENT_ROOT'] . '/resources/view/' . $name . '.php';
        include_once 'resources/view/layout/footer.php';
        unset($_SESSION['error']);
        return $this;
    } 
    public function redirect(string $url): Controller
    {   
        $this->standartRedirect($url);
        return $this;
    }
    public function session(array $arg): void
    {
        $_SESSION = $arg;
    }
}