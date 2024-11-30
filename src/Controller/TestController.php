<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[OA\Get(
        path: '/api/v1/test',
        summary: 'Test Controller for testing',
    )]
    #[OA\Tag(name: 'Test')]
    #[Route(path: '/api/v1/test/index', name: 'api.v1.test.index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([], Response::HTTP_OK);
    }
}