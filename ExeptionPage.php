<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevMode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body class="m-0 p-0" style='background-color: #121212' ;>
    <div class="container d-felx flex-column mb-5" style='background-color: #181818'>
        <div class="text-white pt-3 border-bottom border-dark">
            <div class="d-felx flex-column px-3">
                <div>
                    <p class="h5"> <?php echo $throwableType ?> </p>
                </div>
                <h1> <?php echo $exceptionMassage ?></h1>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="me-3 my-3">
                <?php if (isset($Trace)) { ?>
                    <div class="text-white">vendor frames: </div>
                    <?php
                    foreach ($exceptionTrace as $Trace) {
                        ?>
                        <div class="text-white">
                            <?php

                            printTrace($Trace);
                            echo '<br>';
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                <?php } ?>
            </div>


            <div class="pb-3">
                <div class="d-flex justify-content-end border-start border-dark">
                    <div class="text-warning my-3"><?php echo $exceptionFile . ' : ' . $exceptionLine ?></div>
                </div>
                <div class="d-flex border-start border-dark">
                    <div class="pe-1 ps-1">
                        <?php for ($i = 1; $i < count(file($exceptionFile)) + 1; $i++) {
                            if ($i !== $exceptionLine) {
                                echo '<div class="text-white">' . $i . '</div>';
                            } else {
                                echo '<div class="text-warning">' . $i . '</div>';
                            }
                        } ?>
                    </div>
                    <div class="overflow-x-auto overflow-y-auto text-nowrap mb-5"
                        style="width: 800px;  max-height: 100vh;">
                        <?php
                        $file = file((string) $exceptionFile);
                        $i = 1;
                        foreach ($file as $line) {
                            if ($i !== $exceptionLine) {
                                echo '<div class="text-white">' . '&nbsp&nbsp&nbsp&nbsp&nbsp' . $line . '</div>';
                                $i++;
                            } else {
                                echo '<div class="text-warning">' . '&nbsp&nbsp&nbsp&nbsp&nbsp' . $line;
                                $i++;
                            }

                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>