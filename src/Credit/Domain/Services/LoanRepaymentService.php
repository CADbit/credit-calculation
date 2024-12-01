<?php

declare(strict_types=1);

namespace App\Credit\Domain\Services;

use App\Credit\Domain\Entity\Loan;
use App\Credit\Domain\Entity\LoanSchedule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class LoanRepaymentService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoanRepaymentCalculator $repaymentCalculator
    ) {
    }

    public function createRepaymentSchedule(Loan $loan): void
    {
        $this->entityManager->persist($loan);

        $schedule = $this->repaymentCalculator->generateRepaymentSchedule($loan);

        foreach ($schedule as $loanSchedule) {
            $this->entityManager->persist($loanSchedule);
            $loan->addLoanSchedule($loanSchedule);
        }

        $this->entityManager->flush();
    }

    public function prepareResponse(Uuid $hid): array
    {
        $loan = $this->entityManager->getRepository(Loan::class)->findOneBy([
            'hid' => $hid->toString(),
        ]);

        $schedules = [];

        foreach ($loan->getLoanSchedules() as $schedule) {
            $schedules[] = $schedule;
        }

        $response = [
            'loan' => $this->mapLoanToArray($loan),
            'schedule' => array_map([$this, 'mapLoanScheduleToArray'], $schedules),
        ];

        return $response;
    }

    public function excludeLoan(Uuid $hid): bool
    {
        try {
            $loan = $this->entityManager->getRepository(Loan::class)->findOneBy([
                'hid' => $hid->toString(),
            ]);

            $loan->setExclude(true);

            $this->entityManager->persist($loan);
            $this->entityManager->flush();
        } catch (\Exception $e)
        {
            return false;
        }

        return true;

    }

    private function mapLoanToArray(Loan $loan): array
    {
        return [
            'hid' => $loan->getHid()->toString(),
            'calculation_date' => $loan->getCreateAt()->format('Y-m-d H:i:s'),
            'installments' => $loan->getInstallments(),
            'amount' => number_format($loan->getAmount(), 2, '.', '') . ' zł',
            'interest_rate' => round($loan->getRrso(), 2) . ' %',
        ];
    }

    private function mapLoanScheduleToArray(LoanSchedule $loanSchedule): array
    {
        return [
            'installment_number' => $loanSchedule->getInstallmentNumber(),
            'monthly_repayment' => number_format($loanSchedule->getInstallmentAmount(), 2, '.', '') . ' zł',
            'monthly_interest_payment' => number_format($loanSchedule->getInterestAmount(), 2, '.', '') . ' zł',
            'monthly_principal_payment' => number_format($loanSchedule->getPrincipalAmount(), 2, '.', '') . ' zł',
        ];
    }
}
