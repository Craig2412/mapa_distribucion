<?php

namespace App\Domain\Parroquias\Repository;

use App\Factory\QueryFactory;

final class ParroquiasFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findParroquiass(int $municipio_id): array
    {
        $query = $this->queryFactory->newSelect('parroquias');

        $query->select(
            [
                'id',
                'parroquia'
            ]
        );
        $query->where(['id_municipio' => $municipio_id]);

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
