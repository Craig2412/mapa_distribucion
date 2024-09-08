<?php

namespace App\Domain\Paises\Repository;

use App\Factory\QueryFactory;

final class PaisesFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findPaisess(): array
    {
        $query = $this->queryFactory->newSelect('paises');

        $query->select(
            [
                'paises.id',
                'paises.pais'
            ]

        );
        $query->order(['pais' => 'ASC']);
        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
