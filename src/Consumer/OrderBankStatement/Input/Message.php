<?php
declare(strict_types=1);

namespace App\Consumer\OrderBankStatement\Input;

use DateTimeImmutable;
use Exception;
use JsonException;
use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    #[Assert\NotBlank]
    private ?DateTimeImmutable $startDate;

    #[Assert\NotBlank]
    private ?DateTimeImmutable $endDate;

    #[Assert\NotBlank]
    private ?int $type;

    #[Assert\NotBlank]
    private ?int $userId;

    /**
     * @throws JsonException
     * @throws Exception
     */
    public static function createFromQueue(string $messageBody): self
    {
        $data               = json_decode($messageBody, true, flags: JSON_THROW_ON_ERROR);
        $message            = new static();
        $message->startDate = new DateTimeImmutable($data['startDate']);
        $message->endDate   = new DateTimeImmutable($data['endDate']);
        $message->type      = (int)$data['type'];
        $message->userId    = (int)$data['userId'];

        return $message;
    }

    public function getStartDate(): ?DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }
}
