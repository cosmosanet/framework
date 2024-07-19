<?php

namespace Framework\Api;

class ApiResourses
{
    public function __construct($data)
    {
        header('Content-Type: application/json');
        http_response_code(200);
        print json_encode(
            [
                'data' => $data
            ]
            );
    }
}