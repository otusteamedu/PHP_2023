<?php

declare(strict_types=1);

namespace Otus\Framework\Http;

final class Request
{
    private ?array $request;

    public function __construct()
    {
        $this->request = $this->prepareFields($_REQUEST);
    }

    /**
     * @param $key
     *
     * @return mixed|string|null
     */
    public function __get($key): mixed
    {
        if (isset($this->request[$key])) {
            return $this->request[$key];
        }

        return null;
    }

    /**
     * @param array|string $data
     *
     * @return string|array|null
     */
    private function prepareFields(array|string $data): null| string | array
    {
        if (empty($data)) {
            return null;
        }

        if (is_array($data)) {
            $dataPrepare = [];
            foreach ($data as $key => $value) {
                $dataPrepare[$key] = $this->prepareFields($value);
            }
            return $dataPrepare;
        }

        return trim(htmlspecialchars($data, ENT_QUOTES));
    }
}
