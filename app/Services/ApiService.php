<?php

namespace App\Services;

class ApiService
{
    public function JsonEncode($data)
    {
        return json_encode($data);
    }

    public function response($code, $message)
    {
        $data = [
            'data' => [
                'code' => "$code",
                'message' => "$message"
            ]
        ];
        return $this->JsonEncode($data);
    }


    public function showOne($data)
    {
        $response = [
            'data' => [
                'code' => '200',
                'message' => 'OK',
                'value' => $data
            ]
        ];
        return $this->JsonEncode($response);
    }


}