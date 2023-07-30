<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Controller;

use IilyukDmitryi\App\Application\Dto\CreateEventRequest;
use IilyukDmitryi\App\Application\Dto\FindEventRequest;
use IilyukDmitryi\App\Application\UseCase\AddEventUseCase;
use IilyukDmitryi\App\Application\UseCase\DeleteEventUseCase;
use IilyukDmitryi\App\Application\UseCase\FindEventUseCase;
use IilyukDmitryi\App\Application\UseCase\ListEventUseCase;
use IilyukDmitryi\App\Infrastructure\Http\Utils\Helper;
use IilyukDmitryi\App\Infrastructure\Http\Utils\TemplateEngine;
use IilyukDmitryi\App\Infrastructure\Repository\EventRepository;
use Throwable;

class EventController
{
    public function addAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            if ($_POST) {
                $createEventRequest = new CreateEventRequest(
                    $_POST['event'],
                    $_POST['priority'],
                    $_POST['params'],
                );
                $repository = new EventRepository();
                $addEventUseCase = new AddEventUseCase($repository);
                $createEventResponse = $addEventUseCase->exec($createEventRequest);
                
                if ($createEventResponse->getCntAdd() === 1) {
                    $templateData['message'] = 'Добавили';
                } elseif ($createEventResponse->getCntAdd() === 0) {
                    $templateData['error'] = 'Такое событие уже есть';
                }
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }
        $storageName = Helper::getStorageName();
        $templateData['TITLE'] = $storageName.' - добавление события';
        $resultHtml = $templateEngine->render('Event/add.php', $templateData);
        echo $resultHtml;
    }
    
    public function findAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            if ($_POST) {
                $findEventRequest = new FindEventRequest($_POST['params']);
                $repository = new EventRepository();
                $findEventUseCase = new FindEventUseCase($repository);
                $findEventResponse = $findEventUseCase->exec($findEventRequest);
                
                $event = $findEventResponse->getEvent();
                if ($event) {
                    $templateData['event'] = $event;
                    $templateData['message'] = 'Нашли';
                } else {
                    $templateData['error'] = 'Событие не найдено';
                }
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }
        $storageName = Helper::getStorageName();
        $templateData['TITLE'] = $storageName.' - поиск события';
        $resultHtml = $templateEngine->render('Event/find.php', $templateData);
        echo $resultHtml;
    }
    
    public function listAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $repository = new EventRepository();
            $listEventUseCase = new ListEventUseCase($repository);
            $listEventResponse = $listEventUseCase->exec();
            $eventList = $listEventResponse->getEventList();
            if ($eventList) {
                $templateData['list'] = $eventList;
            } else {
                $templateData['error'] = 'События не добавлены';
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }
        $storageName = Helper::getStorageName();
        $templateData['TITLE'] = $storageName.' - список всех событий';
        $resultHtml = $templateEngine->render('Event/list.php', $templateData);
        echo $resultHtml;
    }
    
    public function deleteAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $repository = new EventRepository();
            $deleteEventUseCase = new DeleteEventUseCase($repository);
            $res = $deleteEventUseCase->exec();
            
            if ($res) {
                $templateData['message'] = 'События удалены';
            } else {
                $templateData['error'] = 'Ошибка удаления событий';
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }
        $storageName = Helper::getStorageName();
        $templateData['TITLE'] = $storageName.' - удаление всех записей';
        $resultHtml = $templateEngine->render('Event/del.php', $templateData);
        echo $resultHtml;
    }
}
