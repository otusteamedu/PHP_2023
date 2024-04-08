<?php

namespace App\MessageHandler;

use App\Message\QueueProject;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Project;

#[AsMessageHandler]
final class QueueProjectHandler
{
      private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function __invoke(QueueProject $message)
    {
        $projectId = $message->getContent();

        // get project from database
        $project = $this->entityManager
            ->getRepository(Project::class)
            ->find($projectId);
        $project->setStatus('done');
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }
}
