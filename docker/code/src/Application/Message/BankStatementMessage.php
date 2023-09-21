<?php

namespace IilyukDmitryi\App\Application\Message;

class BankStatementMessage extends AbstractMessage
{
    private const MESSAGE_TYPE = 'bankstatement';
    private ?\DateTime $dateStart = null;
    private ?\DateTime $dateEnd = null;
    private string $email = '';


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
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->email = '';

        if ($this->body) {
            $array = json_decode($this->body, true);
            if($this->getType() !== $array['type']) {
               throw new \Exception('Message types do not match');
            }
            if (isset($array['fields']['dateStart'])) {
                $this->dateStart = $array['fields']['dateStart'] ? new \DateTime($array['fields']['dateStart']) : null;
            }
            if (isset($array['fields']['dateEnd'])) {
                $this->dateEnd = $array['fields']['dateEnd'] ? new \DateTime($array['fields']['dateEnd']) : null;
            }
            if (isset($array['fields']['email'])) {
                $this->email = $array['fields']['email'] ?: (string)$array['fields']['email'];
            }
        }
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    /**
     * @return string
     */
    public function getDateEnd(): ?\DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return [
            'dateStart' => $this->dateStart?->format("Y-m-d H:i:s"),
            'dateEnd' => $this->dateEnd?->format("Y-m-d H:i:s"),
            'email' => $this->email,
        ];
    }


    /**
     * @param \DateTime|null $dateStart
     */
    public function setDateStart(?\DateTime $dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @param \DateTime|null $dateEnd
     */
    public function setDateEnd(?\DateTime $dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}