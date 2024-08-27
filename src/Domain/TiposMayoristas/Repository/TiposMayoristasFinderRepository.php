<?php

namespace App\Domain\TiposMayoristas\Repository;

use App\Factory\QueryFactory;

final class TiposMayoristasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findTiposMayoristass(): array
    {
        $query = $this->queryFactory->newSelect('tipos_mayoristas');

        $query->select(
            [
                'id',
                'tipo_mayorista'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
