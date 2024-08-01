<?php

namespace Exception;

use Exception;

class CSRFException extends Exception
{
    public function getHttpStatus(): int
    {
        return 404;
    }
}
