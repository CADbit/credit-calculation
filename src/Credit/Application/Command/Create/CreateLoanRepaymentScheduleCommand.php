<?php

declare(strict_types=1);

namespace App\Credit\Application\Command\Create;

use App\Credit\Domain\VO\Amount;
use App\Credit\Domain\VO\Installments;
use Symfony\Component\Uid\Uuid;

class CreateLoanRepaymentScheduleCommand
{
    public function __construct(
        public Uuid $hid,
        public Amount $amount,
        public Installments $installments
    ) {
    }
}
