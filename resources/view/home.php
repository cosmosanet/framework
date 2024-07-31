<?php

echo  'Статус авторизации: ';
if (isset($_SESSION['Auth'])) {
    echo $_SESSION['Auth'];
} else echo '0';

?>
<p>Записи из бд:</p>
<?php
var_dump($arg);



session_start();
var_dump($_SESSION);

?>
<form action="/" method="get">
    <input type="text" name="id" value="322">
    <input type="submit" value="OK">
</form>

<form action="/post/1/" method="post">
    <?php csrf();?>
    <input type="number" name="id" value="322">
    <input type="text" name="name" value="Григорий">
    <input type="submit" value="OK">
</form>