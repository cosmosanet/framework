<?php
extract($arg, EXTR_SKIP);
?>
<h1>Пользователь <?php echo isset($user) ? $user : null ?> </h1>
<p>Записи из бд:</p>
<?php 
foreach ($request as $item) {
    ?> <p> <?php echo $item['name']; ?> </p> <?php
}
session_start();
var_dump($_SESSION);
?>
<form action="/" method="get">
    <input type="text" name="id" value="322">
    <input type="submit" value="OK">
</form>