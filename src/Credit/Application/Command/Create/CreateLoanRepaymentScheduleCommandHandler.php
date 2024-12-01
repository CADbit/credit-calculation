<?php

declare(strict_types=1);

namespace App\Credit\Application\Command\Create;

use App\Credit\Domain\Entity\Loan;
use App\Credit\Domain\Services\LoanRepaymentService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateLoanRepaymentScheduleCommandHandler
{
    public function __construct(
        private LoanRepaymentService $service
    ) {

    }

    public function __invoke(CreateLoanRepaymentScheduleCommand $command): void
    {
        $loan = new Loan(
            $command->hid,
            $command->installments->getValue(),
            $command->amount->getValue(),
            5
        );

        $this->service->createRepaymentSchedule($loan);
    }
}
