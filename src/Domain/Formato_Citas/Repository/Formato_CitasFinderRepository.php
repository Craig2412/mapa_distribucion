<?php

namespace App\Domain\Formato_Citas\Repository;

use App\Factory\QueryFactory;

final class Formato_CitasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findFormato_Citass(): array
    {
        $query = $this->queryFactory->newSelect('formato_citas');

        $query->select(
            [
                'formato_citas.id',
                'formato_citas.formato_cita'
            ]

        );
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
