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
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $this->fromGet($_GET);
            }
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $this->fromDelete();
            }
        } else {
            $this->fromArgs($arguments);
        }
    }

    public function fromGet(array $args): void
    {
        $this->arguments[1] = 'read';
        $this->arguments['uuid'] = $args['uuid'];
    }

    public function fromDelete(): void
    {
        $this->arguments[1] = 'clr';
    }

    public function fromArgs(array $args): void
    {
        $this->arguments = $args;
    }

    public function fromPost(array $post): void
    {
        $this->arguments[1] = 'add';
        $this->arguments[2] = $post['uuid'];
        if (isset($post['user']['title'])) {
            $this->arguments['user']['title'] = $post['user']['title'];
        }
        $this->arguments['full'] = json_encode($post);
    }

    public function getAction(): string
    {
        return $this->arguments[1];
    }

    public function getFull(): string
    {
        return $this->arguments['full'];
    }

    public function getUuid(): string
    {
        return $this->arguments['uuid'] ?? $this->arguments[2];
    }
}
