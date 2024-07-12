<?php

namespace App\Controllers;

use Framework\Database\Model;
use Framework\Request;

class UserController extends Controller
{
    public function home(Request $request): void
    {
        $db = new Model();
        $request = $db->table('user')->get();
        self::view('home', ['user' => $request[0]['name'], 'request' => $request]);
    }

    public function post(Request $request) 
    {
        var_dump($request->post('id'));
    }
}