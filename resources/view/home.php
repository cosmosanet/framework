<div class="text-center">
    <h1><?php 
    echo $arg['number1'] . ' + ' . $arg['number2'] . ' = ' .  $arg['number1'] + $arg['number2'] ;
    ?></h1>
</div>
<div class="container">
    <div class="w-100 d-flex flex-column align-items-center">
        <div style="width: 400px;">
            <form class="form" action="/calculate" method="get">
                <input class="form-control" type="text" name="number1" value="<?php echo isset($_SESSION['old']['number1'])? $_SESSION['old']['number1'] : $arg['number1'] ?>">
                <?php echo isset($_SESSION['error']['number1'])?
                '<div class="alert alert-danger" role="alert">'
                    . $_SESSION['error']['number1'] . 
                '</div>': '' ?>
                <input class="form-control" type="text" name="number2" value="<?php echo isset($_SESSION['old']['number2'])? $_SESSION['old']['number2'] : $arg['number2'] ?>">
                <?php echo isset($_SESSION['error']['number2'])?
                '<div class="alert alert-danger" role="alert">'
                    . $_SESSION['error']['number2'] . 
                '</div>': '' ?>
                <input class="form-control" type="submit" value="OK">
            </form>
            <form class="form" action="/post/1/" method="post">
                <?php csrf();?>
                <input class="form-control" type="number" name="id" value="322">
                <input class="form-control" type="text" name="name" value="Григорий">
                <input class="form-control" type="submit" value="OK">
            </form>
        </div>
    </div>
</div>