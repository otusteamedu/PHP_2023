<?php

namespace IilyukDmitryi\App\Application\Contract\Messenger;

interface MessageInterface
{
    public function setBody(string $body);
    public function getBody(): string;
    public function getType(): string;
}
