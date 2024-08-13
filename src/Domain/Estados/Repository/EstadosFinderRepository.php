<?php

namespace App\Domain\Estados\Repository;

use App\Factory\QueryFactory;

final class EstadosFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findEstadoss(): array
    {
        $query = $this->queryFactory->newSelect('estados');

        $query->select(
            [
                'id',
                'estado'
            ]
        );
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
