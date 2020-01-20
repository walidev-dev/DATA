<?php

namespace AppBundle\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationSuccessListener
{
    private $tokenTll;

    public function __construct($tokenTll)
    {
        $this->tokenTll = $tokenTll;
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $response = $event->getResponse();
        $data = $event->getData();
        $token = $data['token'];

        $response->headers->setCookie(new Cookie(
            'BEARER',
            $token,
            (new \DateTime())->add(new \DateInterval('PT' . $this->tokenTll . 'S'))
        ));
    }
}