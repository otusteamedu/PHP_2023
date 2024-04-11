<?php

namespace App\Message;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Project;

final class QueueProject
{
    private string $content;
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): int
    {
        return $this->content;
    }
}
