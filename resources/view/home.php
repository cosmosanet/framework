
<?php
if(isset($arg)) { 
    extract($arg, EXTR_SKIP);
} 
?>
<h1>Пользователь <?php echo $user ?></h1>
<p>Записи из бд:</p>
<?php 
foreach($request as $item) {
    echo $item['name']; ?> <br> <?php
}
?>
<form action="/" method="get">
    <input type="text" name="sad" value="123">
    <input type="submit" value="OK">
</form>