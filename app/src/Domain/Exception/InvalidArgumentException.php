<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Domain\Exception;

final class InvalidArgumentException extends \Exception
{
    private readonly array $userMessages;

    public function __construct(string $message = "", array $userMessages = [], int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->userMessages = $userMessages;
    }

    /**
     * @return array
     */
    public function getUserMessages(): array
    {
        return $this->userMessages;
    }
}
