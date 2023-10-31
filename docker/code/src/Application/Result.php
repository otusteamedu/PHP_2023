<?php


namespace IilyukDmitryi\App\Application;

use Exception;
use IilyukDmitryi\App\Application\Error;
use IilyukDmitryi\App\Domain\Exception\UserException;

class Result
{
    
    private array $errors = [];
    private array $data = [];
    
    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        $messages = [];
        /** @var Error $error */
        foreach ($this->errors as $error) {
            $messages[] = $error->getMessage();
        }
        return $messages;
    }
    
    /**
     * @return array
     */
    public function getUserErrorMessages(): array
    {
        $messages = [];
        /** @var Error $error */
        foreach ($this->errors as $error) {
            $messages[] = $error->getUserMessage();
        }
        return $messages;
    }
    
    
    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    /**
     * @param Error $error
     * @return Result
     */
    public function addError(Error $error): void
    {
        $this->errors[] = $error;
    }
    
    public function isSuccess(): bool
    {
        return count($this->errors) === 0;
    }
    
    public function getData(): array
    {
        return $this->data;
    }
    
    public function setData(array $data): void
    {
        $this->data = $data;
    }
    
    /**
     * @throws UserException
     * @throws Exception
     */
    public function throw(): void
    {
        if ($arrMsg = $this->getUserErrorMessages()) {
            $msg = implode("\n", $arrMsg);
            throw new UserException($msg);
        } else {
            $arrMsg = $this->getErrorMessages();
            $msg = implode("\n", $arrMsg);
            throw new Exception($msg);
        }
    }
}