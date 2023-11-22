<?php

namespace src\application;

use src\domain\DataCollection;
use src\domain\entry\Repository;
use src\domain\entry\UserRow;
use src\view\ConsoleClient;
use src\view\UserViewDTO;

class Solution
{
    private DataCollection $allDataCollection;
    private DataCollection $viewCollection;

    public function fetchAll(): void
    {
        $data = (new Repository())->getAll();

        $this->allDataCollection = new DataCollection($data);
    }

    public function prepare(): void
    {
        $dataForView = [];
        /** @var UserRow $itemUserData */
        foreach ($this->allDataCollection->getData() as $itemUserData) {
            $dataForView[] = new UserViewDTO([
                'user'   => $itemUserData->getName(),
                'event'  => $itemUserData->getEvent()->getValue(),
                'notify' => $itemUserData->getNotify()->getValue(),
                'detail' => $itemUserData->getSubscribe()->getValue(),
            ]);
        }

        $this->viewCollection = new DataCollection($dataForView);
    }

    public function view(): void
    {
        $viewClient = new ConsoleClient();
        $viewClient->render([
            'count' => $this->allDataCollection->count(),
            'data'  => $this->viewCollection->getData()
        ]);
        $viewClient->view();
    }
}
