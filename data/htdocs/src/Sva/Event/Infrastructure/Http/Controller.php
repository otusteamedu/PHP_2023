<?php

namespace Sva\Event\Infrastructure\Http;

use Pecee\SimpleRouter\SimpleRouter;
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

    public function get(): void
    {
        $request = Router::request();
        $arInput = ($request->getUrl()->getParams()) ?: [];
        $arEvents = $this->repository->getList($arInput);
        $presenter = (new ApiPresenter());
        $arResult = [];

        foreach ($arEvents as $event) {
            $arResult[] = $presenter->present($event);
        }

        SimpleRouter::response()->json($arResult);
    }

    public function post(): void
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

        SimpleRouter::response()->json($result);
    }

    public function search(): void
    {
        $request = Router::request();
        $arInput = ($request->getUrl()->getParams()) ?: [];
        $arEvents = $this->repository->search($arInput);

        SimpleRouter::response()->json($arEvents);
    }

    public function clear(): void
    {
        $result = [
            'errors' => [],
            'success' => $this->repository->clear()
        ];

        SimpleRouter::response()->json($result);
    }
}
