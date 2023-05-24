<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Vp\App\Application\Dto\Output\ResultSend;

class Statement
{
    public function period(Request $request, Application $app): JsonResponse
    {
        $postData = $request->request->all();

        $validator = $app['services.validator']
            ->validate($app['constraint.period']->getConstraints(), $postData);

        if (!$validator->isValid()) {
            return JsonResponse::create(['error' => $validator->getErrors()]);
        }

        $taskParams = $this->getTaskParams($postData);

        /** @var ResultSend $result */
        $result = $app['bank.statement.period']->createTask(json_encode($taskParams));

        return JsonResponse::create(['result' => $result->getMessage()]);
    }

    private function getTaskParams(array $postData): array
    {
        $taskParams = [
            'email' => $postData['email'],
            'dateStart' => $postData['dateStart'],
            'dateEnd' => $postData['dateEnd'],
        ];
        return $taskParams;
    }
}
