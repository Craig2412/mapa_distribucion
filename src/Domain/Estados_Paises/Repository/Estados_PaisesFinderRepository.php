<?php

namespace App\Domain\Estados_Paises\Repository;

use App\Factory\QueryFactory;

final class Estados_PaisesFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findEstados_Paisess(): array
    {
        $query = $this->queryFactory->newSelect('estados_paises');

        $query->select(
            [
                'estados_paises.id',
                'estados_paises.estado_pais'
            ]

        );
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
