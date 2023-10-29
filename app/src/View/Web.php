<?php

namespace Nikitaglobal\View;

class Web
{
    public static function showForm()
    {
        $tpl = file_get_contents(__DIR__ . '/../../assets/form.html');
        header('Content-Type: text/html; charset=utf-8');
        header('HTTP/1.1 200 OK');
        echo $tpl;
        exit();
    }
    public static function showError($message)
    {
        $tpl = file_get_contents(__DIR__ . '/../../assets/error.html');
        header('Content-Type: text/html; charset=utf-8');
        header('HTTP/1.1 400 Bad Request');
        echo str_replace('{{message}}', $message, $tpl);
        exit();
    }

    public static function showSuccess($message)
    {
        $tpl = file_get_contents(__DIR__ . '/../../assets/success.html');
        header('Content-Type: text/html; charset=utf-8');
        header('HTTP/1.1 200 OK');
        echo str_replace('{{message}}', $message, $tpl);
        exit();
    }
}
