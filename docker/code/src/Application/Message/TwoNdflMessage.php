<?php

namespace IilyukDmitryi\App\Application\Message;

class TwoNdflMessage extends AbstractMessage
{

    private const MESSAGE_TYPE = '2ndfl';
    private int $numMonth = 0;
    private string $email = '';
    private string $uuid = '';

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return TwoNdflMessage
     */
    public function setUuid(string $uuid): TwoNdflMessage
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return static::MESSAGE_TYPE;
    }

    /**
     * @param string $body
     * @return void
     * @throws \Exception
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
        $this->fillProperty();
    }

    /**
     * @throws \Exception
     */
    protected function fillProperty(): void
    {
        $this->numMonth = 0;
        $this->email = '';

        if ($this->body) {
            $array = json_decode($this->body, true);
            if($this->getType() !== $array['type']) {
               throw new \Exception('Message types do not match');
            }
            if (isset($array['fields']['uuid'])) {
                $this->uuid = $array['fields']['uuid'];
            }
            if (isset($array['fields']['numMonth'])) {
                $this->numMonth = $array['fields']['numMonth'] ? (int)($array['fields']['numMonth']) : 0;
            }
            if (isset($array['fields']['email'])) {
                $this->email = $array['fields']['email'] ?: (string)$array['fields']['email'];
            }
        }
    }


    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int|null
     */
    public function getNumMonth(): ?int
    {
        return $this->numMonth;
    }

    /**
     * @param int|null $numMonth
     */
    public function setNumMonth(?int $numMonth): void
    {
        $this->numMonth = $numMonth;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return [
            'uuid' => $this->uuid,
            'numMonth' => $this->numMonth,
            'email' => $this->email,
        ];
    }
}