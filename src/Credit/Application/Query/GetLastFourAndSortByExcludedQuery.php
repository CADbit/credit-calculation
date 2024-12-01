<?php

declare(strict_types=1);

namespace App\Credit\Application\Query;

class GetLastFourAndSortByExcludedQuery
{
    public function __construct(
        public bool $excluded = false
    ) {
    }
}
