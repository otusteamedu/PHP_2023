<?php

namespace Rabbit\Daniel\Notification;

use PHPMailer\PHPMailer\PHPMailer;

class EmailNotification implements NotificationInterface {
    private $mailer;

    private $requestData;

    public function __construct(PHPMailer $mailer, array $requestData) {
        $this->mailer = $mailer;
        $this->requestData = $requestData;
    }

    public function send($message) {
        try {
            $this->mailer->setFrom('from@example.com', 'Mailer');
            $this->mailer->addAddress('palm6991@gmail.com'); // Recipient's email
            $this->mailer->isHTML(true); // Set email format to HTML
            $this->mailer->Subject = 'Your request is being processed';
            $this->mailer->Body    = 'We are processing your request for a bank statement from '.$this->requestData['startDate'].' to '.$this->requestData['endDate'];

            $this->mailer->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $this->mailer->ErrorInfo;
        }
    }
}