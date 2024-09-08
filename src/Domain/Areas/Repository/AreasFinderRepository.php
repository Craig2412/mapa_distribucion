<?php

namespace App\Domain\Areas\Repository;

use App\Factory\QueryFactory;

final class AreasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findAreas(): array
    {
        $query = $this->queryFactory->newSelect('areas');

        $query->select(
            [
                'areas.id',
                'areas.area'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
