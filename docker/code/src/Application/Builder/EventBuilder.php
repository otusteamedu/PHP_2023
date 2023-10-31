<?php


namespace IilyukDmitryi\App\Application\Builder;

use IilyukDmitryi\App\Application\Dto\EventRequestDto;
use IilyukDmitryi\App\Domain\Entity\Event;
use IilyukDmitryi\App\Domain\Exception\UserException;
use IilyukDmitryi\App\Domain\Model\EventModel;
use IilyukDmitryi\App\Domain\Model\UserModel;

class EventBuilder
{
    /**
     * @throws UserException
     */
    public static function build(EventRequestDto $eventRequestDto): Event
    {
        $name = trim($eventRequestDto->getName());
        $id = $eventRequestDto->getId();
       
        if($name === ''){
            throw new UserException("Введите название")  ;
        }
        
        $event = new Event();
        $event->setId($id)->setName($name);
        $eventModel = new EventModel();
        $eventFromRepository = $eventModel->getOrCreateEvent($event);
        
        return $eventFromRepository;
    }
}