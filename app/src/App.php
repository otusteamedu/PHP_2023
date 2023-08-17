<?php

declare(strict_types=1);

namespace Root\App;

class App
{
    private Settings $settings;
    public function __construct(Settings $settings)
    {
        mb_internal_encoding('utf8');
        $this->settings = $settings;
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
                $command = new GetBankStatementCommand($this->settings);
                $command->run($input);
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

    /**
     * @throws AppException
     */
    private function getBankStatement(string $start, string $end, array $notification = []): void
    {
        $query = new Query($this->settings->get('rabbitmq'));
        $query->publish(['start' => $start, 'end' => $end, 'notification' => $notification]);

        Response::echo(true, 'Ожидайте уведомления');
    }
}
