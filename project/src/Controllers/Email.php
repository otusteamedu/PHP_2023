<?php
declare(strict_types=1);

namespace Vp\App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Vp\App\Services\Verifier;

class Email
{
    public function email(Request $request, Application $app): JsonResponse
    {
        $postData = $request->request->all();

        $validator = $app['services.validator']
            ->validate($app['constraint.email']->getConstraints(), $postData);

        if (!$validator->isValid()) {
            return JsonResponse::create(['error' => $validator->getErrors()]);
        }

        $emails = $app['services.preparer']->fromEmail($postData['email']);

        return $this->verification($app['services.verifier'], $emails);
    }

    public function emails(Request $request, Application $app): JsonResponse
    {
        $postData = $request->request->all();

        $validator = $app['services.validator']
            ->validate($app['constraint.emails']->getConstraints(), $postData);

        if (!$validator->isValid()) {
            return JsonResponse::create(['error' => $validator->getErrors()]);
        }

        $emails = $app['services.preparer']->fromEmails($postData['emails']);

        return $this->verification($app['services.verifier'], $emails);
    }

    public function file(Request $request, Application $app): JsonResponse
    {
        $files = $request->files->all();

        $validator = $app['services.validator']
            ->validate($app['constraint.file']->getConstraints(), $files);

        if (!$validator->isValid()) {
            return JsonResponse::create(['error' => $validator->getErrors()]);
        }

        $emails = $app['services.preparer']->fromFile($files['file']);

        return $this->verification($app['services.verifier'], $emails);
    }

    private function verification(Verifier $verifier, $emails): JsonResponse
    {
        $verifier->verification($emails);

        return JsonResponse::create(['result' => $verifier->getResult()]);
    }
}
