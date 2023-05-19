<?php

namespace Sva\Event\Infrastructure\Http;

use Sva\Common\App\App;
use Sva\Event\Domain\Event;
use Sva\Event\Domain\EventRepositoryInterface;
use Pecee\SimpleRouter\SimpleRouter as Router;
use Sva\Event\Infrastructure\ApiPresenter;

class Controller
{
    private EventRepositoryInterface $repository;

    public function __construct()
    {
        $this->repository = App::getInstance()->getContainer()->make(EventRepositoryInterface::class);
    }

    public function get(): string
    {
        $request = Router::request();
        $arInput = ($request->getUrl()->getParams()) ?: [];
        $arEvents = $this->repository->getList($arInput);
        $presenter = (new ApiPresenter());
        $arResult = [];

        foreach ($arEvents as $event) {
            $arResult[] = $presenter->present($event);
        }

        return json_encode($arResult);
    }

    public function post(): string
    {
        $bSuccess = false;
        $result = [
            'errors' => [],
            'success' => false
        ];

        $request = Router::request();
        $helper = $request->getInputHandler();
        $arInput = ($helper->all());
        $arErrors = [];

        if ($arInput['priority'] == null) {
            $arErrors[] = 'Priority is required';
        }

        if ($arInput['conditions'] == null) {
            $arErrors[] = 'Conditions is required';
        }

        if ($arInput['event'] == null) {
            $arErrors[] = 'Event is required';
        }

        if (empty($arErrors)) {
            try {
                $event = new Event($arInput['priority'], $arInput['conditions'], $arInput['event']);
                $bSuccess = $this->repository->add($event);
            } catch (\Exception $e) {
                $arErrors[] = $e->getMessage();
            }
        }

        $result['success'] = $bSuccess;
        $result['errors'] = $arErrors;

        return json_encode($result);
    }

    public function search(): string
    {
        $request = Router::request();
        $arInput = ($request->getUrl()->getParams()) ?: [];
        $arEvents = $this->repository->search($arInput);

        return json_encode($arEvents);
    }

    public function clear(): string
    {
        $result = [
            'errors' => [],
            'success' => $this->repository->clear()
        ];

        return json_encode($result);
    }
}
