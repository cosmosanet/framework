<?php
namespace App\Controllers;
use Framework\Database\Model;
class UserController extends Controller
{
    public function index() {
        if(isset($_POST['sad']))
        self::view('index', ['one' => 'asd', 'two' => 'qwe']);
    }
    public function home() {
        $db = new Model();
        $request = $db->table('user')->get();
        self::view('home', ['user' => $request[0]['name'] , 'request' =>  $request]);
    }
}