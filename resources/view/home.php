<?php

// extract($arg, EXTR_SKIP);

?>
<!-- <h1>Пользователь <?php echo isset($user) ? $user : null ?> </h1> -->
<p>Записи из бд:</p>
<?php


session_start();
var_dump($_SESSION);

?>
<form action="/" method="get">
    <input type="text" name="id" value="322">
    <input type="submit" value="OK">
</form>

<form action="/post/1/" method="post">
    <input type="text" name="id" value="322">
    <input type="submit" value="OK">
</form>