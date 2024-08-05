<?php

use Framework\Facade\Application;

function printTrace(array $arr): void
{
    if (is_array($arr)) {
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                printTrace($value);
            } else
                echo is_int($key) ? '' : $key . ' [' . $value . '] <br>';
        }
    } else
        return;
}
function csrf(): void
{
    echo "<input type='text' name='X-CSRF-Token' value=" . Application::getCSRF() . " >";
}