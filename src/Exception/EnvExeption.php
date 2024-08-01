<?php

namespace Exception;

use Exception;

class EnvExeption extends Exception
{
    public function getHttpStatus(): int
    {
        return 400;
    }
}
