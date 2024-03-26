<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use App\DTO\CarReportDTO;
use App\Entity\CarReport;
use App\Exception\ValidationException;
use App\Service\CarReportService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route(path: '/api/v1/car_report', name: 'api_v1_car_report_')]
class CarReportController extends AbstractController
{
    public function __construct(
        private readonly CarReportService $carReportService,
    ) {
    }

    /**
     * @throws ValidationException
     */
    #[Route(path: '', name: 'store', methods: ['POST'])]
    #[OA\Tag(name: 'CarReport')]
    #[OA\Response(
        response: Response::HTTP_ACCEPTED,
        description: 'Accepted response',
        content: new OA\JsonContent(
            properties: [new OA\Property(property: 'url', type: 'string')]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
        description: 'Validation error',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'title', type: 'string'),
                new OA\Property('errors', type: 'object')
            ]
        )
    )]
    public function store(
        #[MapRequestPayload(serializationContext: [CarReportDTO::INPUT], validationGroups: [CarReportDTO::INPUT])]
        CarReportDTO $carReportDTO
    ): Response {
        $operationId = $this->carReportService->createReportAsync($carReportDTO);

        return $this->json(
            ['url' => $this->generateUrl('api_v1_operation_show', ['id' => $operationId])],
            Response::HTTP_ACCEPTED
        );
    }

    #[Route(path: '/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[OA\Tag(name: 'CarReport')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Successful response',
        content: new Model(type: CarReportDTO::class)
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'not found',
        content: new OA\JsonContent(properties: [
            new OA\Property(property: 'description', type: 'string', example: 'object not found')
        ])
    )]
    public function show(CarReport $carReport): Response
    {
        return $this->json($carReport, Response::HTTP_OK);
    }
}
