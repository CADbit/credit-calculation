<?php

declare(strict_types=1);

namespace App\Credit\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: "loan_schedules")]
class LoanSchedule
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 36, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private string $hid;

    #[ORM\Column(type: "integer", nullable: false)]
    private int $installmentNumber;

    #[ORM\Column(type: "decimal", precision: 15, scale: 2, nullable: false)]
    private float $installmentAmount;

    #[ORM\Column(type: "decimal", precision: 15, scale: 2, nullable: false)]
    private float $interestAmount;

    #[ORM\Column(type: "decimal", precision: 15, scale: 2, nullable: false)]
    private float $principalAmount;

    #[ORM\ManyToOne(targetEntity: Loan::class)]
    #[ORM\JoinColumn(name: 'loan_hid', referencedColumnName: 'hid', nullable: false)]
    private Loan $loan;

    public function __construct(
        int $installmentNumber,
        float $installmentAmount,
        float $interestAmount,
        float $principalAmount,
        Loan $loan
    ) {
        $this->installmentNumber = $installmentNumber;
        $this->installmentAmount = $installmentAmount;
        $this->interestAmount = $interestAmount;
        $this->principalAmount = $principalAmount;
        $this->loan = $loan;
    }

    public function getHid(): Uuid
    {
        return Uuid::fromString($this->hid);
    }

    public function getInstallmentNumber(): int
    {
        return $this->installmentNumber;
    }

    public function getInstallmentAmount(): float
    {
        return $this->installmentAmount;
    }

    public function getInterestAmount(): float
    {
        return $this->interestAmount;
    }

    public function getPrincipalAmount(): float
    {
        return $this->principalAmount;
    }

    public function getLoan(): Loan
    {
        return $this->loan;
    }

    public function setLoan(Loan $loan): void
    {
        $this->loan = $loan;
    }
}
