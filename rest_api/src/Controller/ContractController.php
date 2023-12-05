<?php

namespace App\Controller;

use App\Entity\Builder\ContractBuilder;
use App\Repository\ContractRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/v1', name: 'contracts_api')]
class ContractController extends AbstractController
{
    public function __construct(
        readonly LoggerInterface $logger
    ) {
    }

    #[Route('/contracts', name: 'contracts', methods: 'GET')]
    public function getContracts(ContractRepository $contractRepository): JsonResponse
    {
        return $this->json([
            'contracts' => $contractRepository->findAll(),
        ]);
    }

    #[Route('/contracts/{id}', name: 'contracts_get', methods: 'GET')]
    public function getContract(ContractRepository $contractRepository, int $id): JsonResponse
    {
        $contract = $contractRepository->find($id);

        if (!$contract) {
            $data = [
                'status' => 404,
                'contract' => 'Not found',
            ];

            return $this->json($data, 404);
        }

        return $this->json($contract);
    }

    #[Route('/contracts', name: 'contracts_add', methods: 'POST')]
    public function addContract(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $request = $this->decodeJson($request);

            if (
                !$request
                || !$request->request->get('header')
                || !$request->request->get('preamble')
                || !$request->request->get('text')
                || !$request->request->get('signature')
            ) {
                throw new \Exception('Data no valid');
            }

            $contractBuilder = new ContractBuilder();
            $contract = $contractBuilder
                    ->setHeader($request->request->get('header'))
                    ->setPreamble($request->request->get('preamble'))
                    ->setText($request->request->get('text'))
                    ->setSignature($request->request->get('signature'))
                    ->build();

            $entityManager->persist($contract);
            $entityManager->flush();

            return $this->json([
                'status' => 200,
                'success' => 'Contract added successfully',
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return $this->json([
                'status' => 422,
                'errors' => $e->getMessage(),
            ], 422);
        }
    }

    protected function decodeJson(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (null === $data) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

    #[Route('/contracts/{id}', name: 'contracts_put', methods: 'PUT')]
    public function updateContract(Request $request, EntityManagerInterface $entityManager, ContractRepository $contractRepository, int $id): JsonResponse
    {
        try {
            $contract = $contractRepository->find($id);

            if (!$contract) {
                $data = [
                    'status' => 404,
                    'errors' => 'Contract not found',
                ];

                return $this->json($data, 404);
            }

            $request = $this->decodeJson($request);

            if (
                !$request
                || !$request->request->get('header')
                || !$request->request->get('preamble')
                || !$request->request->get('text')
                || !$request->request->get('signature')
            ) {
                throw new \Exception('Data no valid');
            }

            $contract->setHeader($request->request->get('header'));
            $contract->setPreamble($request->request->get('preamble'));
            $contract->setText($request->request->get('text'));
            $contract->setSignature($request->request->get('signature'));
            $entityManager->flush();

            return $this->json([
                'status' => 200,
                'success' => 'Contract updated successfully',
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return $this->json([
                'status' => 422,
                'errors' => $e->getMessage(),
            ], 422);
        }
    }

    #[Route('/contracts/{id}', name: 'contracts_delete', methods: 'DELETE')]
    public function deleteContract(Request $request, EntityManagerInterface $entityManager, ContractRepository $contractRepository, int $id): JsonResponse
    {
        $contract = $contractRepository->find($id);

        if (!$contract) {
            $data = [
                'status' => 404,
                'errors' => 'Contract not found',
            ];

            return $this->json($data, 404);
        }

        $entityManager->remove($contract);
        $entityManager->flush();

        return $this->json([
            'status' => 200,
            'success' => 'Contract deleted successfully',
        ]);
    }
}
