<?php

if(isset($arg)) { 
    extract($arg, EXTR_SKIP);
} 
session_start();
var_dump($_SESSION);
?>

<h1>Главная страница</h1>
<p> 
    <?php echo isset($post) ? $post : null ?> 
</p>

