<?php

if (isset($arg)) {
    extract($arg, EXTR_SKIP);
}
session_start();
var_dump($_SESSION);

?>

<h1>Главная страница</h1>
<p>
    <a href="/dropSession">SESSION DESTROY</a>
    <a href="/auth">Auth</a>
    <a href="/addition/2/plus/2/">CALC</a>
    <?php echo isset($post) ? $post : null ?>
</p>