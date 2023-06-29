<?php
declare(strict_types=1);

use Decorator\EmailNotifier;
use Decorator\EncryptNotifierDecorator;

$notifier = new EmailNotifier();
$notifier = new EncryptNotifierDecorator($notifier);

echo $notifier->send("Hello, World!");
