<?php

namespace App\Domain\RubrosOrigen\Repository;

use App\Factory\QueryFactory;

final class RubrosOrigenFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findRubrosOrigens(): array
    {
        $query = $this->queryFactory->newSelect('origenes_productos');

        $query->select(
            [
                'id',
                'importacion',
                'origen_especifico'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
