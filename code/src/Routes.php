<?php
declare(strict_types=1);

namespace Eevstifeev\Hw12;

use Eevstifeev\Hw12\Controllers\EventsController;
use Eevstifeev\Hw12\Services\RedisService;
use Eevstifeev\Hw12\Views\IndexView;

class Routes
{

    public static function chooseRoute(): void
    {
        $action = $_REQUEST['action'] ?? 'index';
        if (in_array($action, array('add', 'find', 'getByUuid', 'clear', 'clearAll'))) {
            $storageService = new RedisService();
            $controller = new EventsController($storageService);
            $controller->{$action}();
            return;
        }

        switch ($action) {
            case 'index':
                IndexView::index();
                break;
            default:
                IndexView::notFound();
                break;
        }
    }
}