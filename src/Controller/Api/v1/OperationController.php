<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\DTO\Builder\OperationDTOBuilder;
use App\DTO\Output\OperationDTO;
use App\Entity\Operation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/api/v1/operation', name: 'api_v1_operation_')]
class OperationController extends AbstractController
{
    public function __construct(
        private readonly OperationDTOBuilder $operationDTOBuilder
    ) {
    }

    #[Route(path: '/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Tag(name: 'Operation')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Successful response',
        content: new Model(type: OperationDTO::class)
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'not found',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'description', type: 'string', example: 'object not found')
        ])
    )]
    public function show(#[MapEntity(mapping: ['id' => 'id'])] Operation $operation): Response
    {
        $operationDTO = $this->operationDTOBuilder->buildFromEntity($operation);

        return $this->json($operationDTO, Response::HTTP_OK);
    }
}
