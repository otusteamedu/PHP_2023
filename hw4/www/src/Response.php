<?php
namespace Shabanov\Otusphp;
class Response
{
    private Result $result;
    public function __construct($result)
    {
        $this->result = $result;
    }

    public function showStatus(): void
    {
        if ($this->result->isSuccess()) {
            $this->showSuccess();
        } else {
            $this->showErrors();
        }
    }

    private function showSuccess(): void
    {
        http_response_code(200);
        header('Content-type: application/json');
        $arReturn['success'] = 'Строка содержит корректное количество открытых и закрытых скобок';
        echo json_encode($arReturn);
    }

    private function showErrors(): void
    {
        http_response_code(400);
        header('Content-type: application/json');
        $arReturn['errors'] = $this->result->getErrors();
        echo json_encode($arReturn);
    }
}
