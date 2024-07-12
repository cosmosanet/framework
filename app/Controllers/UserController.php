<?php

namespace App\Controllers;

use Framework\Database\Model;

class UserController extends Controller
{
    public function index(): void
    {
        var_dump(func_get_args());
        if (array_key_exists('id', $_GET)) {
            $get = $_GET['id'];
        } else {
            $get = null;
        }
        self::view('index', ['post' => $get]);
    }
    public function home(): void
    {
        var_dump($_POST);
        $db = new Model();
        $request = $db->table('user')->get();
        self::view('home', ['user' => $request[0]['name'], 'request' => $request]);
    }

    public function post() 
    {
        var_dump($_POST);
        self::redirect('/home')->session(['asd' => $_POST['id']]);
    }
}