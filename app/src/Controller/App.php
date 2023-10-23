<?php

namespace Nikitaglobal\Controller;

use Nikitaglobal\View\Web as View;
use Nikitaglobal\Model\Queues as Queues;

class App
{
    public function __construct()
    {
    }

    public function showForm()
    {
        View::showForm();
    }

    public function processForm()
    {
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        // @TODO: проверить, что даты корректные
        // @TODO: проверить, что даты не больше текущей
        // @TODO проверить результат добавления в очередь
        return View::showSuccess('Запрос успешно отправлен в очередь');
    }
}
