<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Controller;

use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;
use Shabanov\Otusphp\Connect\RabbitMqConnect;
use Symfony\Component\Validator\Constraints as Assert;
use Shabanov\Otusphp\Messaging\Producer\RabbitMqProducer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class ApiController
{
    public function __construct(
        private readonly EntityRepository $leadRepository,
    )
    {}
    public function create(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');

        $errorMessages = $this->validation(['name' => $name, 'email' => $email]);
        if (!empty($errorMessages)) {
            return $this->badResponse($errorMessages);
        }

        $uuid = Uuid::uuid1()->toString();
        $message = json_encode([
            'name' => $name,
            'email' => $email,
            'uuid' => $uuid,
        ]);
        (new RabbitMqProducer(new RabbitMqConnect()))
            ->send($message);

        return $this->successResponse([
            'status' => 'progress',
            'uuid' => $uuid,
        ]);
    }

    public function status(Request $request): Response
    {
        $uuid = $request->get('uuid');
        $errorMessages = $this->validation(['uuid' => $uuid]);
        if (!empty($errorMessages)) {
            return $this->badResponse($errorMessages);
        }

        $lead = $this->leadRepository->findOneBy(['uuid' => $uuid]);
        if (!empty($lead)) {
            return $this->successResponse((array)$lead);
        } else {
            return $this->error404();
        }
    }

    public function list(Request $request): Response
    {
        $leads = $this->leadRepository->findAll();
        if (!empty($leads)) {
            return $this->successResponse($leads);
        } else {
            return $this->error404();
        }
    }

    public function detail(Request $request, array $args): Response
    {
        $id = (int)$args['id'];
        $lead = $this->leadRepository->findById($id);
        if (!empty($lead)) {
            return $this->successResponse((array)$lead);
        } else {
            return $this->error404();
        }
    }

    private function successResponse(array $data): Response
    {
        http_response_code(200);
        return new Response(
            json_encode($data),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
    private function error404(): Response
    {
        http_response_code(404);
        return new Response(
            json_encode(['error' => '404 not found']),
            Response::HTTP_NOT_FOUND,
            ['Content-Type' => 'application/json']
        );
    }

    private function badResponse(array $errors): Response
    {
        http_response_code(400);
        return new Response(
            json_encode(['error' => $errors]),
            Response::HTTP_BAD_REQUEST,
            ['Content-Type' => 'application/json']
        );
    }

    private function validation(array $data): array
    {
        $validator = Validation::createValidator();
        $errorMessages = [];

        if (!empty($data['name'])) {
            $nameConstraints = [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255]),
            ];
            $nameValidation = $validator->validate($data['name'], $nameConstraints);
            if (count($nameValidation) > 0) {
                foreach ($nameValidation as $error) {
                    $errorMessages[] = $error->getMessage();
                }
            }
        }

        if (!empty($data['email'])) {
            $emailConstraints = [
                new Assert\NotBlank(),
                new Assert\Email(),
            ];
            $emailValidation = $validator->validate($data['email'], $emailConstraints);
            if (count($emailValidation) > 0) {
                foreach ($emailValidation as $error) {
                    $errorMessages[] = $error->getMessage();
                }
            }
        }

        if (!empty($data['uuid'])) {
            $uuidConstraints = [
                new Assert\Uuid(),
            ];
            $uuidValidation = $validator->validate($data['uuid'], $uuidConstraints);
            if (count($uuidValidation) > 0) {
                foreach ($uuidValidation as $error) {
                    $errorMessages[] = $error->getMessage();
                }
            }
        }

        return $errorMessages;
    }
}
