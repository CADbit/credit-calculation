<?php

declare(strict_types=1);

namespace App\Credit\Domain\Services;

use App\Credit\Application\Query\GetLastFourAndSortByExcludedQuery;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

readonly class LoanQueryService
{
    public function __construct(
        private MessageBusInterface $bus
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     * @throws ExceptionInterface
     */
    public function getLastFourAndSortByExclude(bool $exclude): array
    {
        $query = new GetLastFourAndSortByExcludedQuery($exclude);

        $envelope = $this->bus->dispatch($query);
        $handledStamp = $envelope->last(HandledStamp::class);

        if ($handledStamp) {
            return $handledStamp->getResult();
        }

        return [];
    }
}
