<?php

namespace App\Shared\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof AccessDeniedException) {
            $data = [
                'error' => 'Access Denied',
                'message' => 'You do not have permission to access this resource.',
            ];

            $response = new JsonResponse($data, Response::HTTP_FORBIDDEN);
            $event->setResponse($response);
        }
    }
}