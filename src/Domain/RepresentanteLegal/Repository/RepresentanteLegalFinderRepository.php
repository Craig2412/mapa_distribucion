<?php

namespace App\Domain\RepresentanteLegal\Repository;

use App\Factory\QueryFactory;

final class RepresentanteLegalFinderRepository
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;
    }

    public function findRepresentanteLegals(): array
    {
        $query = $this->queryFactory->newSelect('datos_representante_legal');

        $query->select(
            [
                'id',
                'nombres',
                'apellidos',
                'identificacion',
                'correo',
                'telefono'
            ]
        );

        return $query->execute()->fetchAll('assoc') ?: [];
        
    }
}
