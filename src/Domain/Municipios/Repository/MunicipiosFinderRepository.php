<?php

namespace App\Domain\Municipios\Repository;

use App\Factory\QueryFactory;

final class MunicipiosFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findMunicipioss(int $estado_id): array
    {
        $query = $this->queryFactory->newSelect('municipios');

        $query->select(
            [
                'id',
                'municipio'
            ]
        );
        $query->where(['id_estado' => $estado_id]);

        return $query->execute()->fetchAll('assoc') ?: [];
    }
}
