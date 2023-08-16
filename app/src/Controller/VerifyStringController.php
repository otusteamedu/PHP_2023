<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\EmptyStringException;
use App\Service\StringBracketsVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[Route('/verify_string')]
class VerifyStringController extends AbstractController
{
    private StringBracketsVerifier $stringVerifier;

    public function __construct(StringBracketsVerifier $stringVerifier)
    {
        $this->stringVerifier = $stringVerifier;
    }

    /**
     * @throws EmptyStringException
     */
    #[Route('', name: 'app_string_verifier', methods: 'POST')]
    public function verifyStingBrackets(Request $request): JsonResponse
    {
        $string = $request->get('string');

        $isValid = $this->stringVerifier->verify((string)$string);

        if (!$isValid) {
            return $this->json('brackets in string does not match', Response::HTTP_BAD_REQUEST);
        }

        return $this->json('OK');
    }
}
