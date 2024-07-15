<?php

namespace App\Controllers;

use Framework\Database\Model;
use Framework\Request;

class UserController extends Controller
{
    public function home(Request $request, int $number1, string $number2, $op = ' = '): void
    {
        echo $number1 . '+' . $number2 . $op .  $number1 + $number2;
        $db = new Model();
        $request = $db->table('user')->get();
        self::view('home', ['user' => $request[0]['name'], 'request' => $request]);
    }

    public function post(Request $request, $id) 
    {
        var_dump($id);
        var_dump($request->post('id'));
    }
}