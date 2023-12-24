<?php

namespace App\Controller;

use App\Repository\SomeRepositoryInterface;
use App\Service\PaymentApiService\ApiServiceInterface;
use App\ValueObject\CardExpiration;
use App\ValueObject\CardHolder;
use App\ValueObject\CardNumber;
use App\ValueObject\Cvv;
use App\ValueObject\OrderNumber;
use App\ValueObject\OrderSum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('api/v1', name: 'order_api')]
class SomeController extends AbstractController
{
    #[Route('/orders', name: 'orders_pay', methods: 'GET')]
    public function payOrder(Request $request, ApiServiceInterface $apiService, SomeRepositoryInterface $objectRepository): JsonResponse
    {
        try {
            $request = $this->decodeJson($request);

            if (
                !$request
                || !$request->request->get('card_number')
                || !$request->request->get('card_holder')
                || !$request->request->get('card_expiration')
                || !$request->request->get('cvv')
                || !$request->request->get('order_number')
                || !$request->request->get('sum')
            ) {
                throw new \Exception('Data no valid');
            }

            $data = $request->toArray();

            // use value objects like validators
            $cardNumber = new CardNumber($data['card_number']);
            $cardHolder = new CardHolder($data['card_holder']);
            $cardExpiration = new CardExpiration($data['card_expiration']);
            $cvv = new Cvv($data['cvv']);
            $orderNumber = new OrderNumber($data['order_number']);
            $orderSum = new OrderSum($data['sum']);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 400,
                'error' => $e->getMessage(),
            ], 400);
        }

        $codeResponse = $apiService->sendRequest($data);

        if (403 === $codeResponse) {
            return $this->json([
                'status' => 403,
                'error' => 'api error',
            ], 403);
        }

        if (!$objectRepository->setOrderIsPaid($orderNumber->getNumber(), (float) $orderSum->getSum())) {
            return $this->json([
                'status' => 400,
                'error' => 'sum has not been debited',
            ], 400);
        }

        return $this->json([
            'status' => 200,
            'message' => 'order is paid',
        ]);
    }

    private function decodeJson(Request $request): Request
    {
        $data = json_decode($request->getContent(), true);

        if (null === $data) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
