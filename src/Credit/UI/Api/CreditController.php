<?php

declare(strict_types=1);

namespace App\Credit\UI\Api;

use App\Credit\Application\Command\Create\CreateLoanRepaymentScheduleCommand;
use App\Credit\Domain\Services\LoanRepaymentService;
use App\Credit\Domain\VO\Amount;
use App\Credit\Domain\VO\Installments;
use App\Credit\UI\Request\CreateLoanRepaymentScheduleRequest;
use InvalidArgumentException;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        private readonly LoanRepaymentService $service
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
                    $installments
                )
            );

            $result = $this->service->prepareResponse($hid);
        } catch (InvalidArgumentException | ExceptionInterface $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], 400);
        }

        return $this->json($result);
    }

    public function removeCalculation()
    {

    }

    public function showCalculations()
    {

    }
}
