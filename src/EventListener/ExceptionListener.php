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
        $statusCode = $exception->getCode();

        if ($exception instanceof AppException) {
            $statusCode = $exception->getErrorCode();
        }
        // Check if the status code is invalid and set a default value if it is
        if ($statusCode < 100 || $statusCode >= 600) {
            $statusCode = 500;
        }
        $response = new JsonResponse(['error' => $message], $statusCode);
        $event->setResponse($response);
    }
}
