<?php

namespace Radovinetch\Code;

use RuntimeException;
use Throwable;

class App
{
    /**
     * @param array $strings
     * @return array
     */
    private function checkEmails(array $strings): array
    {
        return array_combine($strings, array_map(
            function (string $string): bool {
                $split = explode('@', $string);
                return filter_var($string, FILTER_VALIDATE_EMAIL) && (count($split) == 2 && checkdnsrr($split[1]));
            }, $strings
        ));
    }

    public function handle(): void
    {
        try {
            $contents = json_decode(file_get_contents("php://input"), true, 512, JSON_THROW_ON_ERROR);

            if (!isset($contents['emails'])) {
                throw new RuntimeException('Параметр emails не был передан');
            }

            $this->response([
                'status' => true,
                'result' => $this->checkEmails(explode(';', $contents['emails']))
            ]);
        } catch (Throwable $throwable) {
            $this->response([
                'status' => false,
                'message' => $throwable->getMessage()
            ], 500);
        }
    }

    private function response(array $data, int $status = 200): void
    {
        echo json_encode($data);
        http_response_code($status);
    }
}