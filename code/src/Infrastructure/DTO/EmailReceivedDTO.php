<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\DTO;

use JsonException;

class EmailReceivedDTO
{
    private string $from;

    private string $to;

    private string $body;

    private string $title;

    private string $attachment;

    private array $payload;

    public function __construct(array $data)
    {
        $this->from = $data['from'] ;
        $this->to = $data['to'] ;
        $this->title = $data['title'] ;

        $this->payload =
            [
                'from' => $data['from'],
                'to' =>$data['to'],
                //body' => $data['body'],
                'title' => $data['title'],
                //'attachment' => $data['attachment'],
            ];
    }

    /**
     * @throws JsonException
     */
    public function toAMQPMessage(): string
    {
        return json_encode($this->payload, JSON_THROW_ON_ERROR);
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getAttachment(): string
    {
        return $this->attachment;
    }
}