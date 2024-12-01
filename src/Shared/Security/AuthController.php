<?php

declare(strict_types=1);

namespace App\Shared\Security;

use App\Shared\Security\User\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly JWTTokenManagerInterface $jwtManager,
    ) {
    }

    #[Route(path: '/api/login', name: 'api.login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $token = $this->jwtManager->create(new User('admin', ['ROLE_USER']));

        return $this->json([
            'token' => $token,
        ]);
    }
}
