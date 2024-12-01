<?php

declare(strict_types=1);

namespace App\Credit\UI\Api;

use App\Credit\Application\Command\Create\CreateLoanRepaymentScheduleCommand;
use App\Credit\Domain\Services\LoanQueryService;
use App\Credit\Domain\Services\LoanRepaymentService;
use App\Credit\Domain\VO\Amount;
use App\Credit\Domain\VO\Installments;
use App\Credit\UI\Request\CreateLoanRepaymentScheduleRequest;
use App\Credit\UI\Request\CreditFilterRequest;
use App\Credit\UI\Request\ExcludeLoanRequest;
use InvalidArgumentException;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Uuid;

class CreditController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly LoanRepaymentService $service,
        private readonly LoanQueryService $queryService
    ) {
    }

    #[OA\Post(
        path: '/api/v1/credit/calculation',
        summary: 'End-point for calculating loan installments with a fixed interest rate (RRSO)',
        security: []
    )]
    #[OA\Tag(name: 'Credit')]
    #[Route(path: '/api/v1/credit/calculation', name: 'api.v1.credit.calculation', methods: ['POST'])]
    #[IsGranted('PUBLIC_ACCESS')]
    public function calculation(#[MapRequestPayload] CreateLoanRepaymentScheduleRequest $request): JsonResponse
    {
        $result = [];

        try {
            $amount = new Amount($request->amount);
            $installments = new Installments($request->installments);

            $hid = Uuid::v7();

            $this->bus->dispatch(
                new CreateLoanRepaymentScheduleCommand(
                    $hid,
                    $amount,
                    $installments,
                    $request->rrso
                )
            );

            $result = $this->service->prepareResponse($hid);
        } catch (InvalidArgumentException | ExceptionInterface $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($result);
    }

    #[OA\Put(
        path: '/api/v1/credit/exclude',
        summary: 'End-point for exclude calculation by HID',
        security: [
            [
                'Bearer' => [],
            ],
        ]
    )]
    #[OA\Tag(name: 'Credit')]
    #[Route(path: '/api/v1/credit/exclude', name: 'api.v1.credit.exclude', methods: ['PUT'])]
    public function excludeCalculation(#[MapRequestPayload] ExcludeLoanRequest $request): JsonResponse
    {
        return $this->json([
            'success' => $this->service->excludeLoan(Uuid::fromString($request->hid)),
        ]);
    }

    #[OA\Get(
        path: '/api/v1/credit/show',
        summary: 'End-point for show last 4 calculation by filters',
        security: [
            [
                'Bearer' => [],
            ],
        ],
    )]
    #[OA\Tag(name: 'Credit')]
    #[Route(path: '/api/v1/credit/show', name: 'api.v1.credit.show', methods: ['GET'])]
    public function showCalculations(#[MapQueryString] CreditFilterRequest $request): JsonResponse
    {
        $result = [];

        try {
            $result = $this->queryService->getLastFourAndSortByExclude((bool) $request->computeFilterValue());
        } catch (ExceptionInterface $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json($result);
    }
}
