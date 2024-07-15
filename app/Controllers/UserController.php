<?php

namespace App\Controllers;

use Framework\Database\Model;
use Framework\Request;

class UserController extends Controller
{
    public function home(Request $request, int $number1, string $number2, $operator): void
    {
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo $number1 . ' + ' . $number2 . $operator .  $number1 + $number2;
        $db = new Model();
        $request = $db->table('user')->get();
        self::view('home', ['user' => $request[0]['name'], 'request' => $request]);
    }

    public function post(Request $request) 
    {
        echo 'POST';
    }
}