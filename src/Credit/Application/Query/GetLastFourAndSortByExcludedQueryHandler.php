<?php

declare(strict_types=1);

namespace App\Credit\Application\Query;

use App\Credit\Domain\Services\LoanRepaymentService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetLastFourAndSortByExcludedQueryHandler
{
    public function __construct(
        private LoanRepaymentService $service
    ) {
    }

    public function __invoke(GetLastFourAndSortByExcludedQuery $query): array
    {
        $result = $this->service->getLastFour($query->excluded);

        return $result;
    }
}
