<?php

namespace App\Shared\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class CustomAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        $data = [
            'error' => 'Authentication Required',
            'message' => $authException ? $authException->getMessage() : 'Access Denied',
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
