<?php

declare(strict_types=1);

namespace App\Bank\Infrastructure\Controller;

use App\Bank\Application\DTO\BankStatementRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BankController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/api/v1/bank/statement")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param BankStatementRequest $request
     * @return Response
     */
    public function statement(BankStatementRequest $request): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
