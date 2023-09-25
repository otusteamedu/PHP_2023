<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Controller\Api\v1;

use Art\Code\Domain\Entity\RequestStatus;
use Art\Code\Infrastructure\Broker\Rabbit\RabbitMQConnector;
use Art\Code\Infrastructure\DB\PDO\PDOConnection;
use Art\Code\Infrastructure\DTO\RequestDTO;
use Art\Code\Infrastructure\Interface\ConnectorInterface;
use Art\Code\Infrastructure\Interface\DBConnectionInterface;
use Art\Code\Infrastructure\Interface\RequestPublisherInterface;
use Art\Code\Infrastructure\Response\Response;
use Art\Code\Infrastructure\Services\Queue\RequestPublisher\RequestPublisher;
use Art\Code\Infrastructure\Services\Request\RequestService;
use JsonException;


/**
 * @OA\Info(title=" API для выполнение запросов от клиента ", version="1.0")
 */
class RequestController
{
    private RequestService $requestService;

    private readonly DBConnectionInterface $DBConnection;

    private readonly ConnectorInterface $queueConnector;

    private readonly RequestPublisherInterface $publisher;

    public function __construct()
    {
        $this->queueConnector = new RabbitMQConnector();
        $this->publisher = new RequestPublisher($this->queueConnector);
        $this->DBConnection = new PDOConnection();
        $this->requestService = new RequestService();
    }

    /**
     * @throws JsonException
     */
    public function index(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->post();
        } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->get();
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/request/post",
     *     summary="Отправить запрос на получение данных опредленного типа",
     *     @OA\Parameter (in = "query",  name = "user_id", required = true, description = "Пользовататель", example = "1", @OA\Schema(type = "integer")),
     *     @OA\Parameter (in = "query",  name = "request_type_id", required = true, description = "Тип запроса",  example = "11", @OA\Schema(type = "integer")),
     *     @OA\Parameter (in = "query",  name = "email", required = true, description = "Куда отправить результат",  example = "test@example.com", @OA\Schema(type = "string")),
     *     @OA\Parameter (in = "query",  name = "dateFrom", required = true, description = "Дата начала периода",  example = "20.03.2013", @OA\Schema(type = "string")),
     *     @OA\Parameter (in = "query",  name = "dateTill", required = true, description = "Дата окончания периода",  example = "20.09.2023", @OA\Schema(type = "string")),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="400", description="BAD REQUEST"),
     * )
     * @throws JsonException
     */
    public function post(): void
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось создать заявку");
        }

        $pdo = $this->DBConnection->getConnection();

        $data = $_REQUEST;
        $data['request_status_id'] = RequestStatus::REQUEST_STATUS_INIT;

        $dto = new RequestDTO($data);

        $requestNumber = $this->requestService->saveRequest($pdo, $dto);

        $data['request_id'] = $requestNumber;

        $this->publisher->send($data);

        if ($requestNumber) {
            Response::send(Response::HTTP_CODE_OK, "Ваш запрос принят в работу. Номер отслеживания " . $requestNumber);
        } else {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось создать заявку");
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/request/get{request_id}",
     *     summary="Метод получения информации по запросу используя ID",
     *     @OA\Parameter (in = "query",  name = "request_id", required = true, description = "Номер запроса", example = "22" ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="400", description="BAD REQUEST"),
     * )
     */
    public function get(): void
    {
        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось получить статус");
        }

        $request_id = $_GET['request_id'];
        $pdo = $this->DBConnection->getConnection();
        $request = $this->requestService->getRequest($pdo, $request_id);

        if ($request) {
            Response::send(Response::HTTP_CODE_OK, "Ваш запрос $request_id имеет статус " . $request->getStatus()->getName());
        } else {
            Response::send(Response::HTTP_CODE_BAD_REQUEST, "Не удалось получить статус");
        }
    }
}