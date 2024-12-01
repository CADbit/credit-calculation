<?php

declare(strict_types=1);

namespace App\Credit\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;

class LoanReadRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    /**
     * @return array<int, mixed>
     * @throws Exception
     */
    public function findLastFour(bool $exclude = false): array
    {
        $rows = $this->connection->createQueryBuilder()
            ->select('l.hid AS hid', 'SUM(ls.interest_amount) AS total_interest')
            ->from('loan', 'l')
            ->join('l', 'loan_schedules', 'ls', 'l.hid = ls.loan_hid')
            ->where('l.exclude = :exclude')
            ->setParameter('exclude', (int) $exclude, ParameterType::INTEGER)
            ->groupBy('l.hid')
            ->orderBy('total_interest', 'DESC')
            ->setMaxResults(4)
            ->executeQuery()
            ->fetchAllAssociative();

        return $rows;
    }
}
