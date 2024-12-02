<?php

declare(strict_types=1);

namespace App\Shared;

use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = null;

        if ($exception instanceof InvalidArgumentException) {
            $response = new JsonResponse([
                'error' => 'Invalid input provided.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof Exception) {
            $response = new JsonResponse([
                'error' => $exception->getMessage(),
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($response) {
            $event->setResponse($response);
        }
    }
}
