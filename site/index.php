<?php

use App\Verify\Post;

require_once 'vendor/autoload.php';
try {
    $verifyPost = new Post($_SERVER, $_POST);
    http_response_code(Post::STATUS_200);
    echo $verifyPost->checkString();
} catch (\Exception $e) {
    http_response_code($e->getCode() ?? Post::STATUS_400);
    echo $e->getMessage();
}

