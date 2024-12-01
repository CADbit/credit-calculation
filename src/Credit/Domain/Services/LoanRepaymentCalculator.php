<?php

declare(strict_types=1);

namespace App\Credit\Domain\Services;

use App\Credit\Domain\Entity\Loan;
use App\Credit\Domain\Entity\LoanSchedule;

class LoanRepaymentCalculator
{
    public function generateRepaymentSchedule(Loan $loan): array
    {
        $monthlyRepayment = $this->calculateMonthlyRepayment($loan);
        $remainingBalance = $loan->getAmount();
        $loanTermInMonths = $loan->getInstallments();
        $paymentsPerYear = 12;

        $schedule = [];

        for ($i = 1; $i <= $loanTermInMonths; $i++) {
            $monthlyInterestPayment = $remainingBalance * ($loan->getRrso() / 100 / $paymentsPerYear);
            $monthlyPrincipalPayment = $monthlyRepayment - $monthlyInterestPayment;
            $remainingBalance -= $monthlyPrincipalPayment;

            $loanSchedule = new LoanSchedule(
                $i,
                round($monthlyRepayment, 2),
                round($monthlyInterestPayment, 2),
                round($monthlyPrincipalPayment, 2),
                $loan
            );

            $schedule[] = $loanSchedule;
        }

        return $schedule;
    }

    private function calculateMonthlyRepayment(Loan $loan): float
    {
        $principalAmount = $loan->getAmount();
        $annualInterestRate = $loan->getRrso();
        $loanTermInMonths = $loan->getInstallments();
        $paymentsPerYear = 12;

        $monthlyInterestRate = $annualInterestRate / $paymentsPerYear / 100;

        $monthlyRepayment = $principalAmount * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $loanTermInMonths))
            / (pow(1 + $monthlyInterestRate, $loanTermInMonths) - 1);

        return $monthlyRepayment;
    }
}
