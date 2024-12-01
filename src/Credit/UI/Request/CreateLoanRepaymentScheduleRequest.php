<?php

declare(strict_types=1);

namespace App\Credit\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateLoanRepaymentScheduleRequest
{
    #[Assert\Type("integer")]
    #[Assert\Range(min: 1000, max: 12000)]
    #[Assert\DivisibleBy(500)]
    public int $amount;

    #[Assert\Type("integer")]
    #[Assert\Range(min: 3, max: 18)]
    #[Assert\DivisibleBy(3)]
    public int $installments;

    public function __construct(int $amount, int $installments)
    {
        $this->amount = $amount;
        $this->installments = $installments;
    }
}
