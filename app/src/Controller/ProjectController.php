<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Message\QueueProject;
use Symfony\Component\Messenger\MessageBusInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;

#[Route('/api', name: 'api_')]
class ProjectController extends AbstractController
{
    /**
     * Get all projects.
     * 
     * This call takes into account all confirmed awards, but not pending or refused awards.

     */
    #[Route('/projects', name: 'project_index', methods:['get'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the projects',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Project::class, groups: ['full']))
        )
    )]
    #[OA\Tag(name: 'projects')]
    #[Security(name: 'Bearer')]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $products = $entityManager
            ->getRepository(Project::class)
            ->findAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
               'id' => $product->getId(),
               'name' => $product->getName(),
               'description' => $product->getDescription(),
               'status' => $product->getStatus()
            ];
        }

        return $this->json($data);
    }
    
    #[Route('/projects', name: 'project_create', methods:['POST'])]
    #[OA\RequestBody(
        content: [new OA\MediaType(mediaType: "application/x-www-form-urlencoded",
            schema: new OA\Schema(
                type: "object",
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string")
                ],
                required: ["name", "description"]
            )
        )]
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the created project',
        content: [new OA\MediaType(mediaType: "application/json",
            schema: new OA\Schema(
                type: "object",
                properties: [
                    new OA\Property(property: "id", type: "integer"),
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string"),
                    new OA\Property(property: "status", type: "string")
                ]
            )
        )]
    )]
    #[OA\Tag(name: 'projects')]
    #[Security(name: 'Bearer')]
    public function create(EntityManagerInterface $entityManager, Request $request, MessageBusInterface $bus): JsonResponse
    {
        $project = new Project();
        $project->setName($request->request->get('name'));
        $project->setDescription($request->request->get('description'));
        $project->setStatus('new');

        $entityManager->persist($project);
        $entityManager->flush();

        $data =  [
            'id' => $project->getId(),
            'name' => $project->getName(),
            'description' => $project->getDescription(),
            'status' => $project->getStatus()
        ];
        $bus->dispatch(new QueueProject($project->getId()));

        return $this->json($data);
    }


   
    #[Route('/projects/{id}', name: 'project_show', methods:['GET'])]
    #[OA\Parameter(
        name: "id",
        in: "path",
        description: "The ID of the project",
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the project details',
        content: [new OA\MediaType(mediaType: "application/json")]
    )]
    #[OA\Response(
        response: 404,
        description: 'Project not found'
    )]
    #[OA\Tag(name: 'projects')]
    #[Security(name: 'Bearer')]
   public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        if (!$project) {
            return $this->json('No project found for id ' . $id, 404);
        }

        $data =  [
            'id' => $project->getId(),
            'name' => $project->getName(),
            'description' => $project->getDescription(),
            'status' => $project->getStatus()
        ];

        return $this->json($data);
    }

}

