<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Controller;

use IilyukDmitryi\App\Application\UseCase\CreateBurgerUseCase;
use IilyukDmitryi\App\Application\UseCase\CreateHotDogUseCase;
use IilyukDmitryi\App\Application\UseCase\CreateSandwichUseCase;
use IilyukDmitryi\App\Infrastructure\Http\Utils\TemplateEngine;

use Throwable;

class CafeController
{
    public function burgerAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $response = CreateBurgerUseCase::exec();
            if($response->isError()){
                $templateData['error'] =  $response->getMessage();
            } else {
                $templateData['message'] =  $response->getMessage();
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }

        $templateData['TITLE'] = 'Хочу бургер';
        $resultHtml = $templateEngine->render('cafe/order.php', $templateData);
        echo $resultHtml;
    }

    public function sandwichAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $response = CreateSandwichUseCase::exec();
            if($response->isError()){
                $templateData['error'] =  $response->getMessage();
            } else {
                $templateData['message'] =  $response->getMessage();
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }

        $templateData['TITLE'] = 'Хочу сэндвич';
        $resultHtml = $templateEngine->render('cafe/order.php', $templateData);
        echo $resultHtml;
    }

    public function hotdogAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $response = CreateHotDogUseCase::exec();
            if($response->isError()){
                $templateData['error'] =  $response->getMessage();
            } else {
                $templateData['message'] =  $response->getMessage();
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }

        $templateData['TITLE'] = 'Хочу прокси-хотдог';
        $resultHtml = $templateEngine->render('cafe/order.php', $templateData);
        echo $resultHtml;
    }
}
