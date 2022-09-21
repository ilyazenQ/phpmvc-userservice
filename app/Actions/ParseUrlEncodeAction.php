<?php

namespace App\Actions;

class ParseUrlEncodeAction
{
    public function execute()
    {
        parse_str(file_get_contents("php://input"), $data);
        $data = (object)$data;
        return $data;
    }
}