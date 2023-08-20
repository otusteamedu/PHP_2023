<?php

declare(strict_types=1);

namespace Root\App;

class GetBankStatementCommand
{
    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @throws AppException
     */
    public function run(array $params): void
    {
        list($start, $end, $notification) = $this->parseParams($params);

        $query = new Query($this->settings->get('rabbitmq'));
        $query->publish(['start' => $start, 'end' => $end, 'notification' => $notification]);

        Response::echo(true, 'Ожидайте уведомления');
    }

    /**
     * @throws AppException
     */
    private function parseParams(array $params): array
    {
        $dateStart = $params['dateStart'] ?? null;
        $dateEnd = $params['dateEnd'] ?? null;
        $notification = $params['notification'] ?? [];
        if (!is_array($notification)) {
            $notification = [];
        }

        if (empty($dateStart) || empty($dateEnd)) {
            throw new AppException('Empty date start or date end');
        }
        return [$dateStart, $dateEnd, $notification];
    }
}
