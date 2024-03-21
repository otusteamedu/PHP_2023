<?php

namespace Rabbit\Daniel\Request;

use PDO;
use Rabbit\Daniel\Notification\NotificationInterface;
use Rabbit\Daniel\Queue\QueuePublisher;

class RequestHandler {
    private PDO $db;
    private QueuePublisher $queuePublisher;

    public function __construct(PDO $db, QueuePublisher $queuePublisher) {
        $this->db = $db;
        $this->queuePublisher = $queuePublisher;
    }

    public function handle($requestData, NotificationInterface $notification) {
        // Assume $requestData contains 'startDate', 'endDate', 'notificationMethod'
        $startDate = $requestData['startDate'];
        $endDate = $requestData['endDate'];

        // Insert the request into the database
        $stmt = $this->db->prepare("INSERT INTO Requests (start_date, end_date, status) VALUES (:startDate, :endDate, 'pending')");
        if (!$stmt->execute([':startDate' => $startDate, ':endDate' => $endDate])) {
            throw new \Exception("Failed to insert request");
        }
        $requestId = $this->db->lastInsertId();

        // Send a notification
        $notificationMessage = "Your request for a statement from $startDate to $endDate has been received and is being processed.";
        $notification->send($notificationMessage);

        // Publish to RabbitMQ queue
        $queueData = [
            'requestId' => $requestId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'notificationMethod' => $requestData['notificationMethod'],
            'chat_id' => $requestData['chat_id'] ?? 1
        ];
        $this->queuePublisher->publish($queueData);

        // Optionally, return success or further instructions
        return "Request processed successfully.";
    }
}