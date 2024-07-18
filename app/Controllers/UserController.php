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
        $request = $db->table('user')->join('qwe')->on('user.id', '=', 'qwe.id')->get();
        // $db->table('user')->insert(['id' => null, 'name' => 'Alex']);
        $this->view('home', ['allusers' => $request]);
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
        self::redirect('/')->session(['Auth' => 1]);
    }

    public function post(Request $request, $id)
    {
        echo $id;
    }
}