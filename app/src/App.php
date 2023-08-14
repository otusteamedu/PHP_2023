<?php

declare(strict_types=1);

namespace Root\App;

class App
{
    public function __construct()
    {
        mb_internal_encoding('utf8');
    }

    /**
     * @throws AppException
     */
    public function run(): void
    {
        $input = $this->getBodyJson();
        if (count($input) === 0) {
            throw new AppException('Empty input');
        }

        $type = $input['type'] ?? null;
        switch ($type) {
            case 'get_bank_statement':
                $dateStart = $input['dateStart'] ?? null;
                $dateEnd = $input['dateEnd'] ?? null;
                $notification = $input['notification'] ?? [];
                if (!is_array($notification)) {
                    $notification = [];
                }

                if (empty($dateStart) || empty($dateEnd)) {
                    throw new AppException('Empty date start or date end');
                }
                $this->getBankStatement($dateStart, $dateEnd, $notification);
                break;
            default:
                throw new AppException('Unknown type');
        }
    }

    /**
     * @throws AppException
     */
    private function getBodyJson(): array
    {
        $postData = file_get_contents('php://input');
        if ($postData === false) {
            throw new AppException('Error read input data');
        }
        $data = json_decode($postData, true);
        if ($data === null) {
            throw new AppException('Error parse input json');
        }
        return $data;
    }

    private function getBankStatement(string $start, string $end, array $notification = []): void
    {
        $query = new Query();
        $query->publish(['start' => $start, 'end' => $end, 'notification' => $notification]);

        Response::echo(true, 'Ожидайте уведомления');
    }
}
