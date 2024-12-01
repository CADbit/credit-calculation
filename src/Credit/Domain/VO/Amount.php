<?php

declare(strict_types=1);

namespace App\Credit\Domain\VO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class Amount
{
    #[Assert\Type("integer")]
    #[Assert\Range(min: 1000, max: 12000)]
    #[Assert\DivisibleBy(500)]
    public function __construct(
        private int $value
    ) {
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
