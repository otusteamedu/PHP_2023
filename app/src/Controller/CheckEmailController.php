<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\EmailChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{File\UploadedFile, JsonResponse, Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[Route('/check_email')]
class CheckEmailController extends AbstractController
{
    private EmailChecker $emailChecker;

    public function __construct(EmailChecker $emailChecker)
    {
        $this->emailChecker = $emailChecker;
    }

    #[Route('', name: 'check_email_single', methods: 'GET')]
    public function checkEmail(Request $request): JsonResponse
    {
        $email = $request->get('email', '');

        $isValid = $this->emailChecker->isEmailValid($email);

        if (!$isValid) {
            return $this->json(EmailChecker::NOT_VALID_EMAIL_MESSAGE, Response::HTTP_BAD_REQUEST);
        }

        return $this->json('OK');
    }

    #[Route('', name: 'check_email_file', methods: 'POST')]
    public function checkEmailWithFile(Request $request): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('emails');

        $checkResult = $this->emailChecker->checkEmailWithFile($file);

        return $this->json([
            'success' => count($checkResult->getValidEmail()),
            'failure' => count($checkResult->getInvalidEmail()),
        ]);
    }
}
