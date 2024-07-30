<?php

namespace App\Controllers;

use App\Models\User;
use Framework\Api\ApiResourses;
use Framework\Database\DBSingleton;
use Framework\Database\Model;
use Framework\Database\OtherSingleton;
use Framework\Facade\Route;
use Framework\Request;
use Framework\Singleton\ConfigSingleton;
use Framework\Singleton\Singletone;

class UserController extends Controller
{
    public function home(Request $request, int $number1, string $number2): void
    {
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
        // $user = new User();
        // new ApiResourses($user->get());
        echo 'CSRF РАБОТАЕТ';
    }
}