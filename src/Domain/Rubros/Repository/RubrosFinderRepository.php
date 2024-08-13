<?php

namespace App\Domain\Rubros\Repository;

use App\Factory\QueryFactory;

final class RubrosFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findRubross(): array
    {
        $query = $this->queryFactory->newSelect('rubros');

        $query->select(
            [
                'id',
                'rubro',
                'presentacion',
                'precio_ves',
                'precio_ptr'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
