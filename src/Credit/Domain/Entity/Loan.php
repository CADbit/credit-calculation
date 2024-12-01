<?php

declare(strict_types=1);

namespace App\Credit\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: "loan")]
class Loan
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 36, unique: true)]
    private string $hid;

    #[ORM\Column(type: "integer", nullable: false)]
    private int $installments;

    #[ORM\Column(type: "integer", nullable: false)]
    private int $amount;

    #[ORM\Column(type: "decimal", precision: 15, scale: 2, nullable: false)]
    private float $rrso;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private DateTimeImmutable $createAt;

    #[ORM\OneToMany(targetEntity: LoanSchedule::class, mappedBy: 'loan')]
    private Collection $loanSchedules;

    #[ORM\Column(type: "boolean", nullable: true)]
    private ?bool $exclude = null;

    public function __construct(
        Uuid $hid,
        int $installments,
        int $amount,
        float $rrso,
        bool $exclude = false
    ) {
        $this->hid = $hid->toString();
        $this->installments = $installments;
        $this->amount = $amount;
        $this->rrso = $rrso;
        $this->createAt = new DateTimeImmutable();
        $this->loanSchedules = new ArrayCollection();
        $this->exclude = $exclude;
    }

    public function getHid(): Uuid
    {
        return Uuid::fromString($this->hid);
    }

    public function getInstallments(): int
    {
        return $this->installments;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getRrso(): float
    {
        return $this->rrso;
    }

    public function getCreateAt(): DateTimeImmutable
    {
        return $this->createAt;
    }

    public function getLoanSchedules(): Collection
    {
        return $this->loanSchedules;
    }

    public function addLoanSchedule(LoanSchedule $loanSchedule): void
    {
        if (! $this->loanSchedules->contains($loanSchedule)) {
            $this->loanSchedules[] = $loanSchedule;
            $loanSchedule->setLoan($this);
        }
    }

    public function removeLoanSchedule(LoanSchedule $loanSchedule): void
    {
        if ($this->loanSchedules->contains($loanSchedule)) {
            $this->loanSchedules->removeElement($loanSchedule);
        }
    }

    public function isExclude(): bool
    {
        return $this->exclude;
    }

    public function setExclude(bool $exclude): void
    {
        $this->exclude = $exclude;
    }
}
