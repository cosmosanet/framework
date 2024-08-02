<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Framework\Database\Model;
use Framework\Http\Request;

class UserController extends Controller
{
    public function home(Request $request, int $number1, int $number2): void
    {
        $db = new Model();
        $user = $db->table('user')->join('qwe')->on('user.id', '=', 'qwe.id')->get();
        $this->view('home', ['allusers' => $user, 'number1' =>  $number1, 'number2' => $number2]);
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

    public function calculate(Request $request)
    {
        $validate = $request->validate([
            'number1' => 'require|int|min:1',
            'number2' => 'require|int|min:1'
        ]);
        // if ($validate) {
            $get = $request->get();
            self::redirect('/addition/'. $get['number1'] . '/plus/'. $get['number2']);
        // }
    }
    
}