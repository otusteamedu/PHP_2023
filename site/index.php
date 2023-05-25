<?php

use App\Verify\Post;

require_once 'vendor/autoload.php';
try {
    $verifyPost = new Post();
    echo $verifyPost->checkString();
} catch (\Exception $e) {
    http_response_code($e->getCode() ?? Post::STATUS_400);
    echo $e->getMessage();
}
