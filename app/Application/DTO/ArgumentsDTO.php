<?php

namespace App\Application\DTO;

class ArgumentsDTO
{
    private array $arguments;

    public function __construct(array $arguments)
    {
        if (empty($arguments)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->fromPost($_POST);
            }
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $this->fromDelete();
            }
        } else {
            $this->fromArgs($arguments);
        }
    }

    public function fromDelete()
    {
        $this->arguments[1] = 'clr';
    }

    public function fromArgs(array $args)
    {
        $this->arguments = $args;
        if (6 === count($args)) {
            $this->arguments['start'] = $this->createFromArg($args[3]);
            $this->arguments['stop'] = $this->createFromArg($args[4]);
        }
    }

    public function fromPost(array $post)
    {
        $this->arguments[1] = 'add';
        $this->arguments[2] = $post['uid'];
        $this->arguments[3] = $this->createFromArg($post['start'])->format('Y-m-d');
        $this->arguments[4] = $this->createFromArg($post['start'])->format('Y-m-d');
        $this->arguments[5] = $post['alias'];
        $this->arguments['start'] = $this->createFromArg($post['start']);
        $this->arguments['stop'] = $this->createFromArg($post['stop']);
        if (isset($post['user']['email'])) {
            $this->arguments['user']['email'] = $post['user']['email'];
        }
        if (isset($post['user']['telegram'])) {
            $this->arguments['user']['telegram'] = $post['user']['telegram'];
        }
        if (isset($post['user']['title'])) {
            $this->arguments['user']['title'] = $post['user']['title'];
        }
        $this->arguments['full'] = json_encode($post);
    }

    private function createFromArg(string $arg): \DateTimeImmutable
    {
        return new \DateTimeImmutable($arg);
    }

    public function getArgs(): array
    {
        return $this->arguments;
    }

    public function getAction(): string
    {
        return $this->arguments[1];
    }

    public function getStartDate(): string
    {
        return $this->arguments['start']->format('Y-m-d');
    }

    public function getStopDate(): string
    {
        return $this->arguments['stop']->format('Y-m-d');
    }

    public function getContactEmail(): string
    {
        return $this->arguments['user']['email'];
    }

    public function getContactTelegram(): string
    {
        return $this->arguments['user']['telegram'];
    }

    public function getContactTitle(): string
    {
        return $this->arguments['user']['title'];
    }

    public function getFull(): string
    {
        return $this->arguments['full'];
    }

    public function getNotify(): string
    {
        return $this->arguments[2];
    }
}
