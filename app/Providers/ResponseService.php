<?php

namespace App\Providers;

class ResponseService
{
    public function success($data, $message) {
        return [
            "success" => true,
            "message" => $message,
            "data" => $data
        ];
    }

    public function error($message, $errorMessage = "Bad Request", $errorCode = 400) {
        return [
            "success" => false,
            "message" => $message,
            "error" => [
                "code" => $errorCode,
                "message" => $errorMessage
            ]
        ];
    }
}
