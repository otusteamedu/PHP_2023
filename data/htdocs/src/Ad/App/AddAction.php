<?php

namespace Ad\App;

use Ad\Domain\AdFile;
use Ad\Infrastructure\AdDTO;
use Ad\Domain\Ad;
use Doctrine\ORM\EntityManagerInterface;
use FileStorage\App\FileManager;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class AddAction
{
    public function __construct(
        private EntityManagerInterface $em,
        private MessageBusInterface $bus
    ) {
    }

    public function execute(AdDTO $adDTO): Ad
    {
        $ad = new Ad();
        $ad->setTitle($adDTO->getTitle());
        $ad->setDescription($adDTO->getDescription());
        $ad->setPrice($adDTO->getPrice());
        $ad->setType($adDTO->getType());
        $ad->setCity($adDTO->getCity());

        foreach ($adDTO->getPhoto() as $photo) {
            $adFile = new AdFile($ad, $photo);
            $this->em->persist($adFile);
            $ad->getPhoto()->add($adFile);
        }

        $this->em->persist($ad);
        $this->em->flush();

        // добавить задачу в очередь
        $this->bus->dispatch($ad);

        return $ad;
    }
}
