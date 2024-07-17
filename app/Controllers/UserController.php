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
        $this->view('home', ['user' => $request[0]['name'], 'request' => $request]);
    }

    public function index(Request $request) 
    {
        self::view('index');
    }

    public function post($id)
    {
        echo $id;
    }
}