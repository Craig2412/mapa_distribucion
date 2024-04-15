<?php

namespace App\Domain\Estatus\Repository;

use App\Factory\QueryFactory;

final class EstatusFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findEstatuss(): array
    {
        $query = $this->queryFactory->newSelect('estatus');

        $query->select(
            [
                'id',
                'estatus'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
