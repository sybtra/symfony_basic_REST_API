<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;

class JWTResponseListener
{
    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        $data = json_decode($event->getResponse()->getContent(), true);
        $errorMessage = $data['message'] ?? 'Authentication failed.';

        $response = new JsonResponse(
            [
                'error' => $errorMessage,
            ],
            JsonResponse::HTTP_UNAUTHORIZED
        );

        $event->setResponse($response);
    }

    public function onJwtNotFound(JWTNotFoundEvent $event)
    {
        $response = new JsonResponse(
            [
                'error' => 'JWT Token not found',
            ],
            JsonResponse::HTTP_UNAUTHORIZED
        );

        $event->setResponse($response);
    }

    public function onJwtInvalid(JWTInvalidEvent $event)
{
    $response = new JsonResponse(
        [
            'error' => 'Invalid JWT token',
        ],
        JsonResponse::HTTP_UNAUTHORIZED
    );

    $event->setResponse($response);
}

}
