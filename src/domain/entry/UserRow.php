<?php

namespace src\domain\entry;

class UserRow
{
    private string $user;
    private string $event;
    private string $notify;
    private Repository $repository;

    private static array $loadedData = [];

    public function __construct(string $user, string $event, string $notify)
    {
        $this->user = $user;
        $this->event = $event;
        $this->notify = $notify;
        $this->repository = new Repository();
    }

    public function getName(): string
    {
        $userByUid = $this->getUserByUid();

        return $userByUid[$this->user]['name'];
    }

    private function getUserByUid(): array
    {
        $keyUserByUid = 'keyUserByUid';
        if (isset(self::$loadedData[$keyUserByUid])) {
            return self::$loadedData[$keyUserByUid];
        }

        $dataUser = $this->repository->getUsers();

        $userByUid = [];
        foreach ($dataUser as $item) {
            $userByUid[$item['uid']] = ['name' => $item['name']];
        }

        self::$loadedData[$keyUserByUid] = $userByUid;

        return $userByUid;
    }

    public function getEvent(): RowInterface
    {
        $eventByUid = $this->getEventByUid();

        return $this->getEntityRow($eventByUid[$this->event]['name'], EventRow::class);
    }

    private function getEventByUid(): array
    {
        $keyEventByUid = 'keyEventByUid';
        if (isset(self::$loadedData[$keyEventByUid])) {
            return self::$loadedData[$keyEventByUid];
        }

        $dataEvent = $this->repository->getEvent();

        $eventByUid = [];
        foreach ($dataEvent as $item) {
            $eventByUid[$item['uid']] = ['name' => $item['name']];
        }

        self::$loadedData[$keyEventByUid] = $eventByUid;

        return $eventByUid;
    }

    public function getNotify(): RowInterface
    {
        $notifyByUid = $this->getNotifyByUid();
        return $this->getEntityRow($notifyByUid[$this->notify]['name'], NotifyRow::class);
    }

    private function getNotifyByUid(): array
    {
        $keyNotifyByUid = 'keyNotifyByUid';
        if (isset(self::$loadedData[$keyNotifyByUid])) {
            return self::$loadedData[$keyNotifyByUid];
        }

        $dataNotify = $this->repository->getNotify();

        $notifyByUid = [];
        foreach ($dataNotify as $item) {
            $notifyByUid[$item['uid']] = ['name' => $item['name']];
        }

        self::$loadedData[$keyNotifyByUid] = $notifyByUid;

        return $notifyByUid;
    }

    public function getSubscribe(): RowInterface
    {
        $detailsByUid = $this->getDetailsByUid();
        $addressNotify = $detailsByUid[$this->user][$this->getNotify()->getValue()]['value'] ?? '';

        return $this->getEntityRow($addressNotify, UserDetailsRow::class);
    }

    private function getDetailsByUid(): array
    {
        $keyDetailByUid = 'keyDetailByUid';
        if (isset(self::$loadedData[$keyDetailByUid])) {
            return self::$loadedData[$keyDetailByUid];
        }

        $dataUserSubscribes = $this->repository->getUserSubscribes();
        $detailsByUid = [];
        foreach ($dataUserSubscribes as $item) {
            $notify = $this->detailTypeToNotify($item['type']);
            $detailsByUid[$item['user']][$notify] = ['value' => $item['value']];
        }
        self::$loadedData[$keyDetailByUid] = $detailsByUid;

        return $detailsByUid;
    }

    private function detailTypeToNotify(string $type): string
    {
        $matches = [
            'phone' => 'sms',
        ];
        return $matches[$type] ?? $type;
    }

    private function getEntityRow(string $value, string $entityRowClassName): RowInterface
    {
        $key = $value . '--' . $entityRowClassName;
        if (isset(self::$loadedData[$key])) {
            return self::$loadedData[$key];
        }

        $entityRow = new $entityRowClassName($value);
        self::$loadedData[$key] = $entityRow;

        return $entityRow;
    }
}
