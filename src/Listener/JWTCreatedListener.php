<?php

namespace App\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    public function __invoke(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();
        $payload = $event->getData();
        $payload['id'] = $user->getId();

        $event->setData($payload);
    }
}
