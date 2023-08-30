<?php

declare(strict_types=1);

use core\Api\Post;

require __DIR__ . "/../vendor/autoload.php";

set_exception_handler(['classes\Exception\HttpException','handleException']);

Post::PostListener();