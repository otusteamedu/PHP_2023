<?php

namespace App\Application\Log;

class Log
{
    public function useRespond($respond, int $httpCode): void
    {
        if ($onceResponse = print_r($respond, true)) {
            $this->printJson($onceResponse, $httpCode);
        }
    }

    public function printConsole(string $line): void
    {
        echo $line;
    }

    public function printOut(string $line): void
    {
        $stdout = fopen('php://stdout', 'wb');
        fwrite($stdout, $line);
    }

    private function printJson(string $message, int $code): void
    {
        $response = json_encode([
            'success' => ((200 <= $code) && ($code <= 299)),
            'data' => json_decode($message)
        ]);
        $this->returnJsonHttpResponse($code, $response);
    }

    private function returnJsonHttpResponse(int $httpCode, $data): void
    {
        ob_start();
        ob_clean();

        header_remove();
        header('Content-type: application/json; charset=utf-8');
        http_response_code($httpCode);

        $this->printConsole($data);
    }

    public function useLogStep(string $message): void
    {
        $this->printOut($message);
        $this->printOut(PHP_EOL);
    }
}
