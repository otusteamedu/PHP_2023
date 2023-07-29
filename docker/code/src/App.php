<?php

namespace IilyukDmitryi\App;


use JetBrains\PhpStorm\NoReturn;

class App
{

    public function run()
    {
        try {
            $this->runAction();

            /*
             *             DemoData::install();
            die;//test_delete
            if(!DemoData::isInstalledDemoData()){
                DemoData::install();
            }
*/
            /*
                        $statistikaController = new StatistikaController();
                        $statistikaController->show1();
                        $statistikaController->show2();*/

            // $this->storage->
            /*

             $elasticStorage = new \IilyukDmitryi\App\Storage\Elastic\ElasticStorage("","","","");
             $channelStorage = $elasticStorage->getChannelStorage();
             $channelStorage->indexExist();

             //ChannelStorage \IilyukDmitryi\App\Storage\Elastic\ChannelStorage($client);

            /* Statistika->graf1()->view(); //Суммарное кол-во лайков и дизлайков для канала по всем его видео
             Statistika->graf2()->view(); //Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков*/
        } catch (\Throwable $e) {
            echo '<pre>' . print_r($e, 1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete
        }
    }


    private function runAction(): void
    {
        $requestURI = $_SERVER['REQUEST_URI'];
        $segments = explode('/', $requestURI);
        $controllerName = ($segments[1]) ? ucfirst($segments[1]) . 'Controller' : 'AppController';
        $controllerClass = static::getControllerClassFullName($controllerName);
        $methodName = ($segments[2] ?? 'index') . "Action";

      /*  echo '<pre>' . print_r([$segments], 1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete
        echo '<pre>' . print_r([$controllerClass, $methodName, class_exists($controllerClass)],
                1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete*/
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $methodName)) {
                $controller->$methodName();
            } else {
                static::show404Page();
            }
        } else {
            static::show404Page();
        }
    }

    #[NoReturn] static function show404Page()
    {
        http_response_code(404);
        $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/404.php';
        if (file_exists($viewPath)) {
            // Включаем "вьюху" для отображения
            include $viewPath;
        } else {
            echo '404 Not Found';
        }
        exit;
    }

    static function getControllerClassFullName(string $controllerName): string
    {
        return '\\' . __NAMESPACE__ . '\\Controller\\' . $controllerName;
    }
}
