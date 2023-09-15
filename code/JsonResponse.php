<?php

class JsonResponse
{
    public int $status;
    public string $message;

    public array $data = [];
    public array $result;


    public function response(int $status, string $message = '', array $data = []): false|string
    {

        $this->status = $status;
        $this->message = $message;
        $this->data = $data;

        $this->result = array(
            'status' => $this->status
        );

        if ($this->message !== '') {
            $this->result['message'] = $this->message;
        }

        if (count($this->data) > 0) {
            $this->result['data'] = $this->data;
        }

        return json_encode($this->result, JSON_THROW_ON_ERROR);
    }
}