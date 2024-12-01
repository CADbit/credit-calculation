<?php

declare(strict_types=1);

namespace App\Credit\Domain\VO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class Installments
{
    #[Assert\Type("integer")]
    #[Assert\Range(min: 3, max: 18)]
    #[Assert\DivisibleBy(3)]
    public function __construct(
        private int $value
    ) {
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
