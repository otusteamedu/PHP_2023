<?php

namespace IilyukDmitryi\App\Application;

use IilyukDmitryi\App\Domain\Exception\UserException;

class Error
{
    private string $message = '';
    private string $toUserMessage = '';
    
    /**
     * @return string
     */
    public function getUserMessage(): string
    {
        return $this->toUserMessage;
    }
    
    /**
     * @param string $toUserMessage
     * @return Error
     */
    public function setUserMessage(string $toUserMessage): Error
    {
        $this->toUserMessage = $toUserMessage;
        return $this;
    }
    
    private int $code = 0;
    private string $trace = '';
    
    /**
     * @return string
     */
    public function getTrace(): string
    {
        return $this->trace;
    }
    
    /**
     * @param string $trace
     * @return Error
     */
    public function setTrace(string $trace): Error
    {
        $this->trace = $trace;
        return $this;
    }
    
    
    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
    
    /**
     * @param string $message
     * @return Result
     */
    public function setMessage(string $message): Error
    {
        $this->message = $message;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getCode(): int
    {
        return $this->code;
    }
    
    /**
     * @param array $code
     * @return Result
     */
    public function setCode(int $code): Error
    {
        $this->code = $code;
        return $this;
    }
    
    
    public static function getFromException(\Throwable $th): self
    {
        $error = (new self())->setMessage($th->getMessage())->setCode((int)$th->getCode())->setTrace(
            (string)$th->getTraceAsString()
        );
        if ($th instanceof UserException) {
            $error->setUserMessage($th->getMessage());
        }
        return $error;
    }
}