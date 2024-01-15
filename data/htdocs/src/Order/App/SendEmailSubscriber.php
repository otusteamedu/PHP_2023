<?php

namespace Order\App;

use Order\App\Event\OrderCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class SendEmailSubscriber implements EventSubscriberInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OrderCreatedEvent::NAME => 'onOrderCreatedEvent',
        ];
    }

    public function onOrderCreatedEvent(OrderCreatedEvent $event): void
    {
        $message = 'Новый заказ: ' . $event->getData()->email . ': [' . $event->getData()->from->format('Y-m-d H:i:s') . '] -> [' . $event->getData()->to->format('Y-m-d H:i:s') . ']';
        $email = new Email();
        $email
            ->subject('Новый заказ')
            ->text($message)
            ->to($event->getData()->email)
            ->from(config()->get('email.from'));

        try {
            $this->mailer->send($email);
        } catch (\Exception $e) {
            var_dump('error' . $e->getMessage());
        }
    }
}
