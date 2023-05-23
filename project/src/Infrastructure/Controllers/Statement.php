<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Vp\App\Services\Verifier;

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
//
//        $emails = $app['services.preparer']->fromEmail($postData['email']);
//
//        return $this->verification($app['services.verifier'], $emails);
        return JsonResponse::create(['result' => '563']);
    }

    private function verification(Verifier $verifier, $emails): JsonResponse
    {
        $verifier->verification($emails);

        return JsonResponse::create(['result' => $verifier->getResult()]);
    }
}
