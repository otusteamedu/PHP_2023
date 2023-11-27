<?php

namespace App;

class JSONMessages
{
    public static function setMessage(string $message): string
    {
        $data = ['message' => $message];

        return json_encode($data);
    }
}
