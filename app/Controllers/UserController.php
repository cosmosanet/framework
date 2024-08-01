<?php

namespace App\Controllers;

use Framework\Database\Model;
use Framework\Request;

class UserController extends Controller
{
    public function home(Request $request, int $number1, string $number2): void
    {
        print_r( $_SESSION['error']);
        echo $number1 . ' + ' . $number2 . ' = ' .  $number1 + $number2;
        $db = new Model();
        $user = $db->table('user')->join('qwe')->on('user.id', '=', 'qwe.id')->get();
        $this->view('home', ['allusers' => $user]);
    }

    public function index(Request $request) 
    { 
        self::view('index');
    }
    public function dropSession()
    {
        session_destroy();
        self::redirect('/');
    }
    public function auth()
    {
        self::redirect('/')->session(['Auth' => 1]);
    }

    public function post(Request $request, $id)
    {
        $request->validate([
            'id' => 'int|max:123',
            'name' => 'require|text|min:6'
        ]);
        echo 'ПОБЕДА';
        // $user = new User();
        // new ApiResourses($user->get());
        // echo 'CSRF РАБОТАЕТ' . $_SERVER['HTTP_REFERER'];
    }
    
}