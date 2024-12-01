<?php

declare(strict_types=1);

namespace App\Credit\UI\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreditFilterRequest
{
    #[Assert\Choice(['all', 'excluded'], message: 'Invalid filter value.')]
    public string $filter = 'all';

    private function getFilterValue(): int
    {
        return $this->filter === 'excluded' ? 1 : 0;
    }

    public function computeFilterValue(): int
    {
        return $this->getFilterValue();
    }
}
