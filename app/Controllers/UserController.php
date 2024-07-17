<?php

namespace App\Controllers;

use Framework\Database\Model;
use Framework\Request;

class UserController extends Controller
{
    public function home(Request $request, int $number1, string $number2): void
    {
        echo $number1 . ' + ' . $number2 . ' = ' .  $number1 + $number2;
        $db = new Model();
        $request = $db->table('user')->get();
        $this->view('home');
    }

    public function index(Request $request) 
    {
        self::view('index');
    }
    public function dropSession()
    {
        session_start();
        session_destroy();
        self::redirect('/');
    }
    public function auth()
    {
        session_start();
        $_SESSION['Auth'] = 1;
        self::redirect('/addition/1/plus/2/');
    }

    public function post($id)
    {
        echo $id;
    }
}