<div class="text-center">
    <h1><?php echo !isset($arg['string']) ? : $arg['string']?></h1>
</div>
<div class="container">

    <form class="form" action="/" method="get">
        <input class="form-control" type="text" name="id" value="322">
        <input class="form-control" type="submit" value="OK">
    </form>

    <form class="form" action="/post/1/" method="post">
        <?php csrf();?>
        <input class="form-control" type="number" name="id" value="322">
        <input class="form-control" type="text" name="name" value="Григорий">
        <input class="form-control" type="submit" value="OK">
    </form>
</div>