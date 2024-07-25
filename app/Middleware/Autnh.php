<?php
namespace App\Middleware;

use Framework\Request;

class Auth
{
    public function zxc(Request $request): ?Request
    {
        session_start();
        if(isset($_SESSION['Auth']))
        {
            return $request;
        }
         else {
            header('Location: http://localhost/');
            // http_response_code()
            return null;
        }
    }
}