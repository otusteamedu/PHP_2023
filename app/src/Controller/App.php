<?php

namespace Nikitaglobal\Controller;

use Nikitaglobal\View\Web as View;

class App
{
    public function __construct()
    {
    }

    public function showForm()
    {
        View::showForm();
        exit();
    }

    public function showTemplate($templateName, $message = '')
    {
        switch ($templateName) {
            case 'form':
                View::showForm();
                break;
            case 'success':
                View::showSuccess($message);
                break;
            case 'error':
                View::showError($message);
                break;
            default:
                View::showError('Неизвестный шаблон');
                break;
        }
    }

    public function prepareData()
    {
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        // @TODO: проверить, что даты корректные
        // @TODO: проверить, что даты не больше текущей
        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

    public function processResult($result)
    {
        if ($result) {
            $this->showTemplate('success', 'Запрос успешно отправлен в очередь');
        } else {
            $this->showError('error', 'Ошибка при отправке запроса в очередь');
        }
        exit();
    }
}
