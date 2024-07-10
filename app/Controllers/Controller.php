<?php
namespace App\Controllers;

class Controller
{
    private $content;
    public function __call($method, $args) {
        $this->$method($args);
    }
    public function view(string $name, ?array $arg = null) {
       include_once $_SERVER['DOCUMENT_ROOT'] . '/resources/view/' . $name . '.php';
       include_once 'resources/view/layout/footer.php';
       include_once 'resources/view/layout/head.php';
    }
}