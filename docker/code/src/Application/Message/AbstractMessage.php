<?php

namespace IilyukDmitryi\App\Application\Message;

use IilyukDmitryi\App\Application\Contract\Messenger\MessageInterface;

abstract class AbstractMessage implements MessageInterface
{
    protected string $body;

    /**
     * @return string
     */
    final public function getBody(): string
    {
        $arrBody = [
            'type' => $this->getType(),
            'fields' => $this->getFields(),
        ];

        return json_encode($arrBody);
    }

    /**
     * @param string $body
     * @return void
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    abstract public function getType(): string;

    abstract public function getFields(): array;


}
