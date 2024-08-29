<?php

namespace App\Domain\TiposMovilizacion\Repository;

use App\Factory\QueryFactory;

final class TiposMovilizacionFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findTiposMovilizacions(): array
    {
        $query = $this->queryFactory->newSelect('tipos_movilizacion');

        $query->select(
            [
                'id',
                'tipo_movilizacion'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
