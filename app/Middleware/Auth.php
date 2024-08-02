<?php
namespace App\Middleware;

use Framework\Http\Request;

class Auth
{
    public function zxc(Request $request): ?Request
    {
        if(isset($_SESSION['Auth']))
        {
            return $request;
        }
         else {
            header('Location: /');
            return null;
        }
    }
}