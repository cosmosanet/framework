<?php

namespace Exception;

use Exception;

class RouteException extends Exception
{
    public function getHttpStatus(): int
    {
        return 401;
    }
}