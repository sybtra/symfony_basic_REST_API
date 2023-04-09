<?php

namespace App\EventListener;

use App\Exception\AppException;
use App\Exception\CustomAppException;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $message = $exception->getMessage();
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof AppException) {
            $statusCode = $exception->getErrorCode();
        }

        $response = new JsonResponse(['error' => $message], $statusCode);
        $event->setResponse($response);
    }
}