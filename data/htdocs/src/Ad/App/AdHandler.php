<?php

namespace Ad\App;

use Ad\Domain\Ad;
use Ad\Domain\Status;
use Psr\Log\LoggerInterface;

class AdHandler
{
    public function __invoke(Ad $ad): void
    {
        $em = container()->get(\Doctrine\ORM\EntityManagerInterface::class);
        $ad2 = $em->find(Ad::class, $ad->getId()); // получаем объект из базы (почему-то не работает с $ad)

        $ad2->setStatus(Status::IN_PROGRESS);
        $em->flush();

        // обработка картинок

        $ad2->setStatus(Status::PROCESSED);
        $em->flush();
    }
}
