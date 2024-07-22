<?php

namespace App\Domain\Estatus_aplicacion\Repository;

use App\Factory\QueryFactory;

final class Estatus_aplicacionFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findEstatus_aplicacions(): array
    {
        $query = $this->queryFactory->newSelect('estatus_aplicacion');

        $query->select(
            [
                'id',
                'estatus_aplicacion'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
